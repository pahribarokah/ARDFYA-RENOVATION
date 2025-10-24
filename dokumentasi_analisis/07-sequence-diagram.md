# 🔄 Sequence Diagram - ARDFYA v2.1

## 📋 Overview Sequence Diagram

Sequence Diagram ARDFYA v2.1 menggambarkan interaksi antar objek dalam urutan waktu untuk setiap proses bisnis utama. Diagram mencakup **Aktor**, **View**, **Controller**, **Model**, dan **Database** dengan atribut dan method yang relevan sesuai Class Diagram.

## 🎯 Sequence Diagram: Guest Ajukan Inquiry

```mermaid
sequenceDiagram
    participant G as Guest
    participant V as InquiryView
    participant IC as InquiryController
    participant S as Service
    participant I as Inquiry
    participant DB as Database
    participant ES as EmailService
    participant A as Admin
    
    Note over G,A: Guest Inquiry Submission Process
    
    G->>V: Akses form inquiry
    V->>IC: GET /inquiry/create
    IC->>S: Service::where('is_active', true)->get()
    S->>DB: SELECT * FROM services WHERE is_active = 1
    DB->>S: Return active services
    S->>IC: Collection<Service>
    IC->>V: return view('inquiry.create', compact('services'))
    V->>G: Tampilkan form dengan layanan
    
    G->>V: Isi form dan submit
    V->>IC: POST /inquiry/store (name, email, phone, service_id, description, budget, address)
    IC->>IC: Validate input data
    
    alt Validation Success
        IC->>I: Inquiry::create($validatedData)
        I->>DB: INSERT INTO inquiries (name, email, phone, service_id, description, budget, address, status, created_at)
        DB->>I: Return inquiry ID
        I->>IC: Inquiry object with ID
        
        IC->>ES: Send notification email to admin
        ES->>A: Email: "New inquiry received from {name}"
        
        IC->>V: redirect()->back()->with('success', 'Inquiry berhasil dikirim')
        V->>G: Tampilkan pesan sukses + opsi registrasi
    else Validation Failed
        IC->>V: redirect()->back()->withErrors($validator)->withInput()
        V->>G: Tampilkan error dan form dengan data lama
    end
```

## 🎯 Sequence Diagram: Customer Login dan Dashboard

```mermaid
sequenceDiagram
    participant C as Customer
    participant LV as LoginView
    participant AC as AuthController
    participant U as User
    participant DB as Database
    participant DV as DashboardView
    participant DC as DashboardController
    participant P as Project
    participant I as Inquiry
    participant N as Notification
    
    Note over C,N: Customer Authentication and Dashboard Access
    
    C->>LV: Akses halaman login
    LV->>AC: GET /login
    AC->>LV: return view('auth.login')
    LV->>C: Tampilkan form login
    
    C->>LV: Input email & password, submit
    LV->>AC: POST /login (email, password)
    AC->>AC: Validate credentials
    AC->>U: User::where('email', $email)->first()
    U->>DB: SELECT * FROM users WHERE email = ?
    DB->>U: Return user data or null
    U->>AC: User object or null
    
    alt Login Success
        AC->>AC: Hash::check($password, $user->password)
        AC->>AC: Auth::login($user)
        AC->>AC: Check user role
        
        alt Role is Customer
            AC->>DV: redirect()->route('customer.dashboard')
            DV->>DC: CustomerDashboardController@index
            DC->>U: Auth::user()
            U->>DC: Current user object
            
            DC->>P: $user->projects()->with('service')->latest()->take(5)->get()
            P->>DB: SELECT projects.*, services.name FROM projects JOIN services WHERE user_id = ? ORDER BY created_at DESC LIMIT 5
            DB->>P: Return recent projects
            P->>DC: Collection<Project>
            
            DC->>I: $user->inquiries()->with('service')->latest()->take(3)->get()
            I->>DB: SELECT inquiries.*, services.name FROM inquiries JOIN services WHERE user_id = ? ORDER BY created_at DESC LIMIT 3
            DB->>I: Return recent inquiries
            I->>DC: Collection<Inquiry>
            
            DC->>N: $user->unreadNotifications()->take(5)->get()
            N->>DB: SELECT * FROM notifications WHERE notifiable_id = ? AND read_at IS NULL LIMIT 5
            DB->>N: Return unread notifications
            N->>DC: Collection<Notification>
            
            DC->>DV: return view('customer.dashboard', compact('projects', 'inquiries', 'notifications'))
            DV->>C: Tampilkan dashboard customer
        else Role is Admin
            AC->>DV: redirect()->route('admin.dashboard')
        end
    else Login Failed
        AC->>LV: redirect()->back()->withErrors(['email' => 'Invalid credentials'])
        LV->>C: Tampilkan error message
    end
```

## 🎯 Sequence Diagram: Customer Chat dengan Admin

```mermaid
sequenceDiagram
    participant C as Customer
    participant CV as ChatView
    participant CC as ChatController
    participant Ch as Chat
    participant DB as Database
    participant P as PusherService
    participant E as LaravelEcho
    participant A as Admin
    participant AV as AdminChatView
    participant NS as NotificationService
    
    Note over C,NS: Real-time Chat Communication
    
    C->>CV: Akses halaman chat
    CV->>CC: GET /messages
    CC->>CC: Auth::user()
    CC->>Ch: Chat::where('customer_id', $userId)->with('admin')->orderBy('created_at')->get()
    Ch->>DB: SELECT chats.*, users.name as admin_name FROM chats LEFT JOIN users ON chats.admin_id = users.id WHERE customer_id = ? ORDER BY created_at
    DB->>Ch: Return chat history
    Ch->>CC: Collection<Chat>
    CC->>CV: return view('messages.customer', compact('chats'))
    CV->>C: Tampilkan interface chat dengan history
    
    C->>CV: Ketik pesan dan klik send
    CV->>CC: POST /chat/send (message, customer_id)
    CC->>CC: Validate message input
    
    alt Message Valid
        CC->>Ch: Chat::create(['customer_id' => $customerId, 'message' => $message, 'is_from_admin' => false, 'is_read' => false])
        Ch->>DB: INSERT INTO chats (customer_id, message, is_from_admin, is_read, created_at)
        DB->>Ch: Return chat ID
        Ch->>CC: Chat object with ID
        
        CC->>P: broadcast(new NewChatMessage($chat))
        P->>E: Broadcast to channel 'chat.{customer_id}' and 'admin.chat'
        E->>AV: Real-time update admin chat interface
        E->>CV: Real-time update customer chat interface
        
        CC->>NS: Send notification to admin
        NS->>A: Database notification + Email (if enabled)
        
        CC->>CV: return response()->json(['status' => 'success', 'chat' => $chat])
        CV->>C: Tampilkan pesan terkirim di interface
    else Message Invalid
        CC->>CV: return response()->json(['status' => 'error', 'message' => 'Validation failed'])
        CV->>C: Tampilkan error message
    end
    
    Note over A,C: Admin Reply Process
    A->>AV: Lihat pesan customer dan ketik balasan
    AV->>CC: POST /admin/chat/reply/{customerId} (message)
    CC->>Ch: Chat::create(['customer_id' => $customerId, 'admin_id' => $adminId, 'message' => $message, 'is_from_admin' => true])
    Ch->>DB: INSERT INTO chats (customer_id, admin_id, message, is_from_admin, created_at)
    DB->>Ch: Return chat ID
    
    CC->>P: broadcast(new NewChatMessage($chat))
    P->>E: Broadcast to customer channel
    E->>CV: Real-time update customer interface
    CV->>C: Tampilkan balasan admin
```

## 🎯 Sequence Diagram: Admin Kelola Project

```mermaid
sequenceDiagram
    participant A as Admin
    participant PV as ProjectView
    participant PC as AdminProjectController
    participant P as Project
    participant U as User
    participant S as Service
    participant I as Inquiry
    participant DB as Database
    participant C as Contract
    participant CC as ContractController
    participant NS as NotificationService
    participant Cust as Customer
    
    Note over A,Cust: Admin Project Management Process
    
    A->>PV: Akses halaman project management
    PV->>PC: GET /admin/projects
    PC->>PC: AdminMiddleware check
    PC->>P: Project::with(['user', 'service', 'inquiry'])->paginate(10)
    P->>DB: SELECT projects.*, users.name, services.name, inquiries.description FROM projects JOIN users JOIN services LEFT JOIN inquiries
    DB->>P: Return projects with relations
    P->>PC: Paginated Collection<Project>
    PC->>PV: return view('admin.projects.index', compact('projects'))
    PV->>A: Tampilkan daftar project dengan pagination
    
    A->>PV: Klik "Create New Project"
    PV->>PC: GET /admin/projects/create
    PC->>U: User::where('role', 'customer')->get()
    U->>DB: SELECT * FROM users WHERE role = 'customer'
    DB->>U: Return customer list
    U->>PC: Collection<User>
    
    PC->>S: Service::where('is_active', true)->get()
    S->>DB: SELECT * FROM services WHERE is_active = 1
    DB->>S: Return active services
    S->>PC: Collection<Service>
    
    PC->>I: Inquiry::where('status', 'approved')->get()
    I->>DB: SELECT * FROM inquiries WHERE status = 'approved'
    DB->>I: Return approved inquiries
    I->>PC: Collection<Inquiry>
    
    PC->>PV: return view('admin.projects.create', compact('customers', 'services', 'inquiries'))
    PV->>A: Tampilkan form create project
    
    A->>PV: Isi form project dan submit
    PV->>PC: POST /admin/projects (name, description, user_id, service_id, inquiry_id, budget, start_date, expected_end_date)
    PC->>PC: Validate project data
    
    alt Validation Success
        PC->>P: Project::create($validatedData)
        P->>DB: INSERT INTO projects (name, description, user_id, service_id, inquiry_id, budget, start_date, expected_end_date, status, progress_percentage, created_at)
        DB->>P: Return project ID
        P->>PC: Project object with ID
        
        alt Auto Generate Contract
            PC->>CC: Generate contract for project
            CC->>C: Contract::create(['project_id' => $projectId, 'user_id' => $userId, 'contract_number' => $generatedNumber, 'amount' => $budget])
            C->>DB: INSERT INTO contracts (project_id, user_id, contract_number, amount, contract_status, created_at)
            DB->>C: Return contract ID
        end
        
        PC->>NS: Send notification to customer
        NS->>Cust: Database notification + Email: "New project created: {project_name}"
        
        PC->>PV: redirect()->route('admin.projects.index')->with('success', 'Project created successfully')
        PV->>A: Tampilkan success message dan redirect ke list
    else Validation Failed
        PC->>PV: redirect()->back()->withErrors($validator)->withInput()
        PV->>A: Tampilkan error dan form dengan data lama
    end
```

## 🎯 Sequence Diagram: Admin Generate PDF Kontrak

```mermaid
sequenceDiagram
    participant A as Admin
    participant CV as ContractView
    participant CC as AdminContractController
    participant C as Contract
    participant P as Project
    participant U as User
    participant DB as Database
    participant PDF as DomPDFService
    participant FS as FileSystem
    
    Note over A,FS: Contract PDF Generation Process
    
    A->>CV: Klik "Generate PDF" pada contract
    CV->>CC: GET /admin/contracts/{contract}/pdf
    CC->>CC: AdminMiddleware check
    CC->>C: Contract::with(['project', 'user'])->findOrFail($contractId)
    C->>DB: SELECT contracts.*, projects.*, users.* FROM contracts JOIN projects JOIN users WHERE contracts.id = ?
    DB->>C: Return contract with relations
    C->>CC: Contract object with Project and User
    
    CC->>PDF: PDF::loadView('admin.contracts.pdf-template', compact('contract'))
    PDF->>PDF: Load HTML template with contract data
    PDF->>PDF: Apply CSS styling
    PDF->>PDF: Convert HTML to PDF
    
    alt PDF Generation Success
        PDF->>CC: PDF binary data
        CC->>FS: Store PDF file (optional)
        CC->>CV: return response($pdf)->header('Content-Type', 'application/pdf')->header('Content-Disposition', 'attachment; filename="contract-{contract_number}.pdf"')
        CV->>A: Download PDF file
    else PDF Generation Failed
        PDF->>CC: Exception thrown
        CC->>CV: redirect()->back()->with('error', 'Failed to generate PDF')
        CV->>A: Tampilkan error message
    end
```

## 🎯 Sequence Diagram: Customer Lihat Progress Project

```mermaid
sequenceDiagram
    participant C as Customer
    participant PV as ProjectView
    participant PC as CustomerProjectController
    participant P as Project
    participant S as Service
    participant DB as Database
    participant E as LaravelEcho
    participant PS as PusherService
    
    Note over C,PS: Customer Project Progress Tracking
    
    C->>PV: Akses halaman project tracking
    PV->>PC: GET /customer/projects
    PC->>PC: Auth::user()
    PC->>P: $user->projects()->with('service')->orderBy('created_at', 'desc')->get()
    P->>DB: SELECT projects.*, services.name FROM projects JOIN services WHERE projects.user_id = ? ORDER BY created_at DESC
    DB->>P: Return customer projects
    P->>PC: Collection<Project>
    PC->>PV: return view('customer.projects', compact('projects'))
    PV->>C: Tampilkan daftar project customer
    
    C->>PV: Klik project untuk lihat detail
    PV->>PC: GET /customer/projects/{project}
    PC->>P: Project::with(['service', 'contract'])->where('user_id', $userId)->findOrFail($projectId)
    P->>DB: SELECT projects.*, services.name, contracts.* FROM projects JOIN services LEFT JOIN contracts WHERE projects.id = ? AND projects.user_id = ?
    DB->>P: Return project detail with relations
    P->>PC: Project object with Service and Contract
    
    PC->>P: $project->update(['customer_last_viewed' => now()])
    P->>DB: UPDATE projects SET customer_last_viewed = NOW() WHERE id = ?
    
    PC->>PV: return view('customer.project-detail', compact('project'))
    PV->>C: Tampilkan detail project dengan progress, timeline, photos
    
    Note over C,PS: Real-time Progress Update
    loop Real-time Updates
        PS->>E: Broadcast project update event
        E->>PV: Listen for 'project.updated' event
        PV->>PC: AJAX GET /api/projects/{project}/progress
        PC->>P: Project::find($projectId)->only(['progress_percentage', 'status', 'project_photos', 'timeline_details'])
        P->>DB: SELECT progress_percentage, status, project_photos, timeline_details FROM projects WHERE id = ?
        DB->>P: Return updated project data
        P->>PC: Project progress data
        PC->>PV: return response()->json($progressData)
        PV->>C: Update UI dengan progress terbaru
    end
```

## 📊 Penjelasan Detail Sequence Diagram

### **1. Object Interactions**

#### **Controller Layer**
- **InquiryController**: Menangani form inquiry dan validasi
- **AuthController**: Proses authentication dan session management
- **AdminProjectController**: CRUD operations untuk project management
- **ChatController**: Real-time messaging dengan broadcasting

#### **Model Layer**
- **User**: Authentication, relationships, role checking
- **Project**: Business logic, progress tracking, relationships
- **Chat**: Message storage, real-time broadcasting
- **Contract**: PDF generation, business calculations

#### **Service Layer**
- **EmailService**: Notification delivery
- **PusherService**: Real-time broadcasting
- **DomPDFService**: PDF document generation
- **NotificationService**: Multi-channel notifications

### **2. Database Interactions**

#### **Query Patterns**
- **Eager Loading**: `with()` untuk optimize N+1 queries
- **Filtering**: `where()` clauses untuk data access control
- **Pagination**: `paginate()` untuk large datasets
- **Relationships**: JOIN queries untuk related data

#### **Data Integrity**
- **Foreign Key Constraints**: Referential integrity
- **Validation**: Input validation sebelum database operations
- **Transactions**: Atomic operations untuk complex workflows

### **3. Real-time Features**

#### **Broadcasting Flow**
```
User Action → Controller → Database → Broadcast Event → Pusher → Laravel Echo → UI Update
```

#### **Notification Flow**
```
System Event → Notification Service → Database Storage → Email Service → User Notification
```

### **4. Security Implementations**

#### **Authentication Flow**
- **Credential Validation**: Hash comparison
- **Session Management**: Laravel session handling
- **Role-based Access**: AdminMiddleware untuk authorization

#### **Data Protection**
- **Input Validation**: Form request validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **CSRF Protection**: Built-in Laravel protection

### **5. Performance Optimizations**

#### **Database Optimization**
- **Eager Loading**: Reduce N+1 query problems
- **Indexing**: Foreign key dan frequently queried columns
- **Pagination**: Limit result sets untuk performance

#### **Caching Strategy**
- **Query Caching**: Cache frequent database queries
- **View Caching**: Cache compiled templates
- **Session Caching**: Optimize session storage

## 🔄 Integration Points

### **1. Frontend-Backend Integration**
- **AJAX Calls**: Real-time data updates
- **Form Submissions**: POST requests dengan validation
- **File Uploads**: Multipart form handling

### **2. External Service Integration**
- **Email Service**: SMTP integration untuk notifications
- **Pusher Service**: WebSocket untuk real-time features
- **PDF Service**: DomPDF untuk document generation

### **3. Database Integration**
- **Eloquent ORM**: Object-relational mapping
- **Migration System**: Database version control
- **Seeder System**: Test data generation

---

**Sequence Diagram ARDFYA v2.1** menggambarkan **interaksi detail** antar komponen sistem dengan **timing yang akurat** dan **data flow yang jelas** untuk mendukung **business process** yang **efisien** dan **reliable**. 🔄
