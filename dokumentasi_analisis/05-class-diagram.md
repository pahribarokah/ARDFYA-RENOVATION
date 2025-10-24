# 🏗️ Class Diagram - ARDFYA v2.1

## 📋 Overview Class Diagram

Class Diagram ARDFYA v2.1 menggambarkan struktur kelas, atribut, method, dan relasi antar kelas yang benar-benar diimplementasikan dalam sistem. Diagram ini mencerminkan arsitektur **Model-View-Controller (MVC)** dengan **Eloquent ORM** sebagai data access layer.

## 🎯 Class Diagram Lengkap

```mermaid
classDiagram
    %% Model Classes
    class User {
        -Long id
        -String name
        -String email
        -Timestamp email_verified_at
        -String password
        -String phone
        -Text address
        -Enum role
        -JSON notification_settings
        -String remember_token
        -Timestamp created_at
        -Timestamp updated_at
        
        +isAdmin() Boolean
        +isCustomer() Boolean
        +inquiries() HasMany
        +projects() HasMany
        +contracts() HasMany
        +customerChats() HasMany
        +adminChats() HasMany
        +notifications() MorphMany
        +getFullNameAttribute() String
        +scopeCustomers() Builder
        +scopeAdmins() Builder
    }
    
    class Service {
        -Long id
        -String name
        -Text description
        -String icon
        -Boolean is_active
        -Timestamp created_at
        -Timestamp updated_at
        
        +projects() HasMany
        +inquiries() HasMany
        +scopeActive() Builder
        +getIconHtmlAttribute() String
    }
    
    class Inquiry {
        -Long id
        -Long user_id
        -Long service_id
        -String name
        -String email
        -String phone
        -String property_type
        -Text address
        -Integer area_size
        -Decimal budget
        -Text description
        -Enum status
        -Text admin_notes
        -Date start_date
        -String schedule_flexibility
        -Text current_condition
        -Timestamp created_at
        -Timestamp updated_at
        
        +user() BelongsTo
        +service() BelongsTo
        +project() HasOne
        +messages() HasMany
        +scopeByStatus() Builder
        +getStatusColorAttribute() String
        +getFormattedBudgetAttribute() String
    }
    
    class Project {
        -Long id
        -Long user_id
        -Long service_id
        -Long inquiry_id
        -String name
        -Text description
        -Enum status
        -Date start_date
        -Date expected_end_date
        -Date actual_end_date
        -Text address
        -Decimal total_cost
        -Decimal budget
        -Decimal budget_used
        -String thumbnail
        -String category
        -Boolean is_featured
        -Integer progress_percentage
        -Text notes
        -String team_assigned
        -JSON project_photos
        -JSON timeline_details
        -Timestamp customer_last_viewed
        -Timestamp created_at
        -Timestamp updated_at
        
        +user() BelongsTo
        +service() BelongsTo
        +inquiry() BelongsTo
        +contract() HasOne
        +chats() HasMany
        +scopeByStatus() Builder
        +scopeFeatured() Builder
        +getStatusColorAttribute() String
        +getProgressBarColorAttribute() String
        +getRemainingBudgetAttribute() Decimal
        +getFormattedCostAttribute() String
    }
    
    class Contract {
        -Long id
        -Long project_id
        -Long user_id
        -String contract_number
        -Date start_date
        -Date end_date
        -Decimal amount
        -Enum contract_status
        -Integer installments
        -Text notes
        -Timestamp created_at
        -Timestamp updated_at
        
        +project() BelongsTo
        +user() BelongsTo
        +generateContractNumber() String
        +getStatusColorAttribute() String
        +getFormattedAmountAttribute() String
        +scopeActive() Builder
        +generatePDF() String
    }
    
    class Portfolio {
        -Long id
        -String title
        -Text description
        -String category
        -String image_path
        -String client_name
        -String location
        -Date completion_date
        -Decimal project_value
        -Boolean is_featured
        -Boolean is_active
        -Integer ordering
        -Timestamp created_at
        -Timestamp updated_at
        
        +scopeActive() Builder
        +scopeFeatured() Builder
        +scopeByCategory() Builder
        +scopeOrdered() Builder
        +getFormattedValueAttribute() String
        +getImageUrlAttribute() String
    }
    
    class Chat {
        -Long id
        -Long customer_id
        -Long admin_id
        -Text message
        -Boolean is_from_admin
        -Boolean is_read
        -String file_url
        -String file_name
        -String file_type
        -Integer file_size
        -Timestamp created_at
        -Timestamp updated_at
        -Timestamp deleted_at
        
        +customer() BelongsTo
        +admin() BelongsTo
        +scopeUnread() Builder
        +scopeForCustomer() Builder
        +markAsRead() Void
        +getFormattedTimeAttribute() String
        +hasAttachment() Boolean
    }
    
    class Notification {
        -String id
        -String type
        -Long notifiable_id
        -String notifiable_type
        -JSON data
        -Timestamp read_at
        -Timestamp created_at
        -Timestamp updated_at
        
        +notifiable() MorphTo
        +markAsRead() Void
        +scopeUnread() Builder
        +getFormattedDataAttribute() Array
    }
    
    %% Controller Classes
    class HomeController {
        +index() View
        +about() View
        +portfolio() View
        +portfolioDetail() View
        +contact() View
    }
    
    class AdminDashboardController {
        +index() View
        +fixOrphanedInquiries() RedirectResponse
    }
    
    class CustomerDashboardController {
        +index() View
    }
    
    class InquiryController {
        +create() View
        +store() RedirectResponse
    }
    
    class AdminInquiryController {
        +index() View
        +show() View
        +update() RedirectResponse
        +destroy() RedirectResponse
        +convertToProject() RedirectResponse
    }
    
    class AdminProjectController {
        +index() View
        +create() View
        +store() RedirectResponse
        +show() View
        +edit() View
        +update() RedirectResponse
        +destroy() RedirectResponse
        +updateProgress() JsonResponse
    }
    
    class AdminContractController {
        +index() View
        +create() View
        +store() RedirectResponse
        +show() View
        +edit() View
        +update() RedirectResponse
        +generatePDF() Response
    }
    
    class AdminPortfolioController {
        +index() View
        +create() View
        +store() RedirectResponse
        +show() View
        +edit() View
        +update() RedirectResponse
        +destroy() RedirectResponse
    }
    
    class ChatController {
        +getMessages() JsonResponse
        +store() JsonResponse
        +markAsRead() JsonResponse
        +getCustomers() JsonResponse
        +getAllChats() JsonResponse
        +adminReply() JsonResponse
    }
    
    %% Middleware Classes
    class AdminMiddleware {
        +handle() Response
    }
    
    %% Relationships
    User ||--o{ Inquiry : "submits"
    User ||--o{ Project : "owns"
    User ||--o{ Contract : "signs"
    User ||--o{ Chat : "customer_participates"
    User ||--o{ Chat : "admin_participates"
    User ||--o{ Notification : "receives"
    
    Service ||--o{ Inquiry : "requested_for"
    Service ||--o{ Project : "used_in"
    
    Inquiry ||--o| Project : "converts_to"
    Project ||--o| Contract : "generates"
    
    Project ||--o{ Chat : "discusses"
    
    %% Controller Dependencies
    HomeController ..> Service : uses
    HomeController ..> Portfolio : uses

    AdminDashboardController ..> User : uses
    AdminDashboardController ..> Inquiry : uses
    AdminDashboardController ..> Project : uses
    AdminDashboardController ..> Contract : uses

    CustomerDashboardController ..> User : uses
    CustomerDashboardController ..> Project : uses
    CustomerDashboardController ..> Inquiry : uses

    InquiryController ..> Inquiry : uses
    InquiryController ..> Service : uses

    AdminInquiryController ..> Inquiry : uses
    AdminInquiryController ..> Project : uses

    AdminProjectController ..> Project : uses
    AdminProjectController ..> User : uses
    AdminProjectController ..> Service : uses

    AdminContractController ..> Contract : uses
    AdminContractController ..> Project : uses

    AdminPortfolioController ..> Portfolio : uses

    ChatController ..> Chat : uses
    ChatController ..> User : uses

    %% Middleware Dependencies
    AdminMiddleware ..> User : validates
```

## 🏗️ Penjelasan Detail Kelas

### **A. Model Classes (Data Layer)**

#### **1. User Class**
**Fungsi**: Representasi pengguna sistem (customer dan admin)

**Atribut Utama**:
- `role`: Enum untuk membedakan customer dan admin
- `notification_settings`: JSON untuk preferensi notifikasi
- `email`: Unique identifier untuk login

**Method Penting**:
- `isAdmin()`: Mengecek apakah user adalah admin
- `isCustomer()`: Mengecek apakah user adalah customer
- Relationship methods untuk akses data terkait

**Relasi**:
- One-to-Many dengan Inquiry, Project, Contract
- Self-referencing Many-to-Many melalui Chat
- Polymorphic One-to-Many dengan Notification

#### **2. Service Class**
**Fungsi**: Representasi layanan yang ditawarkan perusahaan

**Atribut Utama**:
- `name`: Nama layanan
- `description`: Deskripsi lengkap layanan
- `icon`: FontAwesome icon class
- `is_active`: Status aktif layanan

**Method Penting**:
- `scopeActive()`: Query scope untuk layanan aktif
- `getIconHtmlAttribute()`: Generate HTML icon

**Relasi**:
- One-to-Many dengan Inquiry dan Project

#### **3. Inquiry Class**
**Fungsi**: Representasi permintaan layanan dari customer

**Atribut Utama**:
- `status`: Enum untuk tracking workflow
- `budget`: Budget yang dimiliki customer
- `admin_notes`: Catatan internal admin
- `user_id`: Nullable untuk guest inquiry

**Method Penting**:
- `scopeByStatus()`: Filter berdasarkan status
- `getStatusColorAttribute()`: Warna status untuk UI
- `getFormattedBudgetAttribute()`: Format currency

**Relasi**:
- Many-to-One dengan User dan Service
- One-to-One dengan Project (conversion)

#### **4. Project Class**
**Fungsi**: Representasi proyek konstruksi/arsitektur

**Atribut Utama**:
- `progress_percentage`: Progress 0-100
- `project_photos`: JSON array foto progress
- `timeline_details`: JSON timeline proyek
- `budget_used`: Tracking penggunaan budget

**Method Penting**:
- `getRemainingBudgetAttribute()`: Sisa budget
- `getProgressBarColorAttribute()`: Warna progress bar
- `scopeFeatured()`: Proyek unggulan

**Relasi**:
- Many-to-One dengan User, Service, Inquiry
- One-to-One dengan Contract
- One-to-Many dengan Chat

#### **5. Contract Class**
**Fungsi**: Representasi kontrak proyek

**Atribut Utama**:
- `contract_number`: Nomor kontrak unik
- `contract_status`: Status kontrak
- `amount`: Nilai kontrak
- `installments`: Jumlah cicilan

**Method Penting**:
- `generateContractNumber()`: Generate nomor unik
- `generatePDF()`: Generate PDF kontrak
- `getFormattedAmountAttribute()`: Format currency

**Relasi**:
- Many-to-One dengan Project dan User

#### **6. Portfolio Class**
**Fungsi**: Representasi portfolio hasil karya

**Atribut Utama**:
- `is_featured`: Portfolio unggulan
- `is_active`: Status aktif
- `ordering`: Urutan tampil
- `project_value`: Nilai proyek

**Method Penting**:
- `scopeFeatured()`: Portfolio unggulan
- `scopeByCategory()`: Filter kategori
- `getImageUrlAttribute()`: URL gambar

**Relasi**:
- Standalone entity (tidak berelasi langsung)

#### **7. Chat Class**
**Fungsi**: Representasi komunikasi real-time

**Atribut Utama**:
- `is_from_admin`: Pengirim pesan
- `is_read`: Status baca
- `file_*`: Attachment support
- `deleted_at`: Soft delete

**Method Penting**:
- `markAsRead()`: Tandai sudah dibaca
- `hasAttachment()`: Cek ada attachment
- `scopeUnread()`: Pesan belum dibaca

**Relasi**:
- Many-to-One dengan User (customer dan admin)

#### **8. Notification Class**
**Fungsi**: Representasi notifikasi sistem

**Atribut Utama**:
- `id`: UUID primary key
- `type`: Class notification
- `data`: JSON notification data
- `read_at`: Timestamp baca

**Method Penting**:
- `markAsRead()`: Tandai sudah dibaca
- `scopeUnread()`: Notifikasi belum dibaca

**Relasi**:
- Polymorphic Many-to-One dengan User

### **B. Controller Classes (Logic Layer)**

#### **1. HomeController**
**Fungsi**: Menangani halaman publik

**Method Utama**:
- `index()`: Homepage dengan layanan dan portfolio
- `portfolio()`: Halaman portfolio
- `portfolioDetail()`: Detail portfolio

**Dependencies**: Service, Portfolio models

#### **2. AdminDashboardController**
**Fungsi**: Dashboard admin dengan analytics

**Method Utama**:
- `index()`: Dashboard dengan statistik
- `fixOrphanedInquiries()`: Perbaiki data orphaned

**Dependencies**: User, Inquiry, Project, Contract models

#### **3. CustomerDashboardController**
**Fungsi**: Dashboard customer

**Method Utama**:
- `index()`: Dashboard customer dengan project tracking

**Dependencies**: User, Project, Inquiry models

#### **4. InquiryController**
**Fungsi**: Menangani inquiry dari customer/guest

**Method Utama**:
- `create()`: Form inquiry
- `store()`: Simpan inquiry baru

**Dependencies**: Inquiry, Service models

#### **5. AdminInquiryController**
**Fungsi**: Manajemen inquiry oleh admin

**Method Utama**:
- `index()`: Daftar inquiry
- `convertToProject()`: Convert inquiry ke project
- CRUD operations

**Dependencies**: Inquiry, Project models

#### **6. AdminProjectController**
**Fungsi**: Manajemen project oleh admin

**Method Utama**:
- CRUD operations untuk project
- `updateProgress()`: Update progress via AJAX

**Dependencies**: Project, User, Service models

#### **7. AdminContractController**
**Fungsi**: Manajemen kontrak oleh admin

**Method Utama**:
- CRUD operations untuk contract
- `generatePDF()`: Generate PDF kontrak

**Dependencies**: Contract, Project models

#### **8. AdminPortfolioController**
**Fungsi**: Manajemen portfolio oleh admin

**Method Utama**:
- CRUD operations untuk portfolio
- Image upload handling

**Dependencies**: Portfolio model

#### **9. ChatController**
**Fungsi**: Menangani komunikasi real-time

**Method Utama**:
- `getMessages()`: Ambil pesan chat
- `store()`: Kirim pesan baru
- `markAsRead()`: Tandai sudah dibaca
- `adminReply()`: Admin balas pesan

**Dependencies**: Chat, User models

### **C. Middleware Classes (Security Layer)**

#### **1. AdminMiddleware**
**Fungsi**: Memastikan hanya admin yang dapat akses

**Method Utama**:
- `handle()`: Validasi role admin

**Logic**:
- Cek authentication status
- Validasi role = 'admin'
- Redirect jika tidak authorized

## 🔗 Relasi Antar Kelas Detail

### **1. User Relationships**
```php
// One-to-Many relationships
User hasMany Inquiry (user_id)
User hasMany Project (user_id)  
User hasMany Contract (user_id)

// Self-referencing relationships via Chat
User hasMany Chat as customer (customer_id)
User hasMany Chat as admin (admin_id)

// Polymorphic relationship
User morphMany Notification (notifiable)
```

### **2. Business Entity Relationships**
```php
// Service relationships
Service hasMany Inquiry (service_id)
Service hasMany Project (service_id)

// Inquiry to Project conversion
Inquiry hasOne Project (inquiry_id)

// Project to Contract generation  
Project hasOne Contract (project_id)

// Project communication
Project hasMany Chat (project_id)
```

### **3. Controller Dependencies**
```php
// Controllers depend on Models for data access
HomeController uses Service, Portfolio
AdminDashboardController uses User, Inquiry, Project, Contract
InquiryController uses Inquiry, Service
ChatController uses Chat, User
```

## 📊 Design Patterns Implemented

### **1. Active Record Pattern**
- Eloquent models sebagai Active Record
- Model methods untuk business logic
- Built-in CRUD operations

### **2. Repository Pattern (Partial)**
- Eloquent sebagai data access abstraction
- Model scopes sebagai query repositories

### **3. Observer Pattern**
- Model events untuk notifications
- Real-time broadcasting events

### **4. Factory Pattern**
- Model factories untuk testing
- Service container untuk dependency injection

### **5. Strategy Pattern**
- Different notification channels
- Multiple authentication guards

## 🎯 Key Features Implementation

### **1. Authentication & Authorization**
- User model dengan role-based access
- AdminMiddleware untuk authorization
- Session-based authentication

### **2. Real-time Communication**
- Chat model dengan broadcasting
- WebSocket integration via Laravel Echo
- File attachment support

### **3. Business Workflow**
- Inquiry → Project → Contract flow
- Status tracking dengan enums
- Progress monitoring

### **4. Content Management**
- Portfolio management dengan categories
- Featured content system
- Image upload dan optimization

### **5. Notification System**
- Polymorphic notifications
- Multi-channel delivery (database, email)
- User preferences support

---

**Class Diagram ARDFYA v2.1** menggambarkan **arsitektur yang solid** dengan **separation of concerns** yang jelas, **scalable relationships**, dan **maintainable code structure** untuk sistem manajemen konstruksi dan arsitektur. 🏗️
