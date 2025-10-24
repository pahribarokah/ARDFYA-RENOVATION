# Diagram UML - Aplikasi Ardfya v2

## 1. Use Case Diagram

Use Case Diagram menggambarkan interaksi antara aktor (users) dengan sistem dan fitur-fitur yang tersedia.

```mermaid
graph TB
    subgraph "Sistem Ardfya v2"
        UC1[Browse Services]
        UC2[Submit Inquiry]
        UC3[Track Project]
        UC4[Chat with Admin]
        UC5[Manage Profile]
        UC6[View Portfolio]
        
        UC7[Manage Dashboard]
        UC8[Manage Inquiries]
        UC9[Manage Projects]
        UC10[Manage Contracts]
        UC11[Manage Customers]
        UC12[Generate Reports]
        UC13[Chat with Customers]
        UC14[Manage Services]
    end
    
    Customer((Customer))
    Admin((Admin))
    Guest((Guest))
    
    Guest --> UC1
    Guest --> UC6
    Guest --> UC2
    
    Customer --> UC1
    Customer --> UC2
    Customer --> UC3
    Customer --> UC4
    Customer --> UC5
    Customer --> UC6
    
    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
    Admin --> UC14
    
    UC2 -.-> UC8
    UC8 -.-> UC9
    UC9 -.-> UC10
```

## 2. Class Diagram

Class Diagram menunjukkan struktur kelas dalam sistem dan hubungan antar kelas.

```mermaid
classDiagram
    class User {
        +Long id
        +String name
        +String email
        +String password
        +String phone
        +String address
        +String role
        +DateTime created_at
        +DateTime updated_at
        +isAdmin() Boolean
        +projects() HasMany
        +inquiries() HasMany
        +messages() HasMany
        +contracts() HasMany
    }
    
    class Service {
        +Long id
        +String name
        +String slug
        +Text description
        +String short_description
        +String image_path
        +String icon
        +String price_range
        +Boolean is_featured
        +Boolean is_active
        +Integer ordering
        +DateTime created_at
        +DateTime updated_at
        +projects() HasMany
        +inquiries() HasMany
    }
    
    class Inquiry {
        +Long id
        +Long user_id
        +Long service_id
        +String name
        +String email
        +String phone
        +String property_type
        +String address
        +Integer area_size
        +Decimal budget
        +Text description
        +String status
        +Text admin_notes
        +Date start_date
        +String schedule_flexibility
        +Text current_condition
        +DateTime created_at
        +DateTime updated_at
        +user() BelongsTo
        +service() BelongsTo
        +project() HasOne
        +messages() HasMany
    }
    
    class Project {
        +Long id
        +Long user_id
        +Long service_id
        +Long inquiry_id
        +String name
        +Text description
        +String status
        +Date start_date
        +Date expected_end_date
        +Date actual_end_date
        +String address
        +Decimal total_cost
        +Decimal budget
        +String thumbnail
        +String category
        +Boolean is_featured
        +Integer progress_percentage
        +Text notes
        +DateTime created_at
        +DateTime updated_at
        +user() BelongsTo
        +service() BelongsTo
        +inquiry() BelongsTo
        +contract() HasOne
        +projectImages() HasMany
        +messages() HasMany
    }
    
    class Contract {
        +Long id
        +Long project_id
        +Long user_id
        +String contract_number
        +Date start_date
        +Date end_date
        +Decimal amount
        +Decimal paid_amount
        +String contract_file
        +String payment_status
        +String contract_status
        +Date last_payment_date
        +String payment_method
        +Integer installments
        +Text notes
        +DateTime created_at
        +DateTime updated_at
        +project() BelongsTo
        +user() BelongsTo
        +payments() HasMany
        +getRemainingAmountAttribute() Decimal
        +getPaymentPercentageAttribute() Integer
        +generateContractNumber() String
    }
    
    class ContractPayment {
        +Long id
        +Long contract_id
        +Long user_id
        +Decimal amount
        +Date payment_date
        +String payment_method
        +String transaction_id
        +String receipt_number
        +Text notes
        +String receipt_file
        +String status
        +DateTime created_at
        +DateTime updated_at
        +contract() BelongsTo
        +user() BelongsTo
    }
    
    class Message {
        +Long id
        +Long user_id
        +Long project_id
        +Long inquiry_id
        +Text message
        +Boolean is_from_admin
        +Boolean is_read
        +DateTime created_at
        +DateTime updated_at
        +user() BelongsTo
        +project() BelongsTo
        +inquiry() BelongsTo
    }
    
    class Chat {
        +Long id
        +Long customer_id
        +Long admin_id
        +Text message
        +Boolean is_from_admin
        +Boolean is_read
        +String file_url
        +String file_name
        +String file_type
        +Integer file_size
        +DateTime created_at
        +DateTime updated_at
        +customer() BelongsTo
        +admin() BelongsTo
    }
    
    class ProjectImage {
        +Long id
        +Long project_id
        +String image_path
        +Text caption
        +Integer ordering
        +Boolean is_before_image
        +Boolean is_after_image
        +Boolean is_featured
        +DateTime created_at
        +DateTime updated_at
        +project() BelongsTo
    }
    
    %% Relationships
    User ||--o{ Inquiry : "has many"
    User ||--o{ Project : "has many"
    User ||--o{ Contract : "has many"
    User ||--o{ Message : "has many"
    User ||--o{ Chat : "customer"
    User ||--o{ Chat : "admin"
    User ||--o{ ContractPayment : "has many"
    
    Service ||--o{ Inquiry : "has many"
    Service ||--o{ Project : "has many"
    
    Inquiry ||--|| User : "belongs to"
    Inquiry ||--|| Service : "belongs to"
    Inquiry ||--o| Project : "has one"
    Inquiry ||--o{ Message : "has many"
    
    Project ||--|| User : "belongs to"
    Project ||--|| Service : "belongs to"
    Project ||--|| Inquiry : "belongs to"
    Project ||--o| Contract : "has one"
    Project ||--o{ ProjectImage : "has many"
    Project ||--o{ Message : "has many"
    
    Contract ||--|| Project : "belongs to"
    Contract ||--|| User : "belongs to"
    Contract ||--o{ ContractPayment : "has many"
    
    ContractPayment ||--|| Contract : "belongs to"
    ContractPayment ||--|| User : "belongs to"
    
    Message ||--|| User : "belongs to"
    Message ||--|| Project : "belongs to"
    Message ||--|| Inquiry : "belongs to"
    
    Chat ||--|| User : "customer"
    Chat ||--|| User : "admin"
    
    ProjectImage ||--|| Project : "belongs to"
```

## 3. Activity Diagram

### 3.1 Customer Inquiry Process

```mermaid
flowchart TD
    A[Customer visits website] --> B[Browse services]
    B --> C{Interested in service?}
    C -->|Yes| D[Click 'Inquire' button]
    C -->|No| E[Continue browsing]
    E --> B
    
    D --> F[Fill inquiry form]
    F --> G[Submit form]
    G --> H{Form valid?}
    H -->|No| I[Show validation errors]
    I --> F
    H -->|Yes| J[Create/Update user account]
    J --> K[Save inquiry to database]
    K --> L[Send confirmation email]
    L --> M[Redirect to success page]
    
    M --> N[Admin receives notification]
    N --> O[Admin reviews inquiry]
    O --> P{Admin decision}
    P -->|Accept| Q[Contact customer]
    P -->|Need more info| R[Request additional details]
    P -->|Reject| S[Send rejection notice]
    
    Q --> T[Create project]
    R --> U[Customer provides details]
    U --> O
    S --> V[End process]
    T --> W[Project management begins]
```

### 3.2 Project Management Process

```mermaid
flowchart TD
    A[Project created from inquiry] --> B[Set project status to 'Planning']
    B --> C[Admin assigns project details]
    C --> D[Set budget and timeline]
    D --> E[Change status to 'In Progress']
    
    E --> F[Regular progress updates]
    F --> G[Update progress percentage]
    G --> H[Upload project photos]
    H --> I[Customer notification]
    
    I --> J{Project completed?}
    J -->|No| K[Continue work]
    K --> F
    J -->|Yes| L[Change status to 'Completed']
    
    L --> M[Generate final report]
    M --> N[Customer final approval]
    N --> O{Customer satisfied?}
    O -->|Yes| P[Close project]
    O -->|No| Q[Address concerns]
    Q --> F
    
    P --> R[Generate contract if needed]
    R --> S[Process final payment]
    S --> T[Archive project]
```

## 4. Sequence Diagram

### 4.1 Customer Inquiry Submission

```mermaid
sequenceDiagram
    participant C as Customer
    participant W as Website
    participant IC as InquiryController
    participant DB as Database
    participant UC as UserController
    participant E as EmailService
    participant A as Admin
    
    C->>W: Browse services
    W->>C: Display services
    C->>W: Click "Inquire" on service
    W->>C: Show inquiry form
    
    C->>W: Fill and submit form
    W->>IC: POST /inquiries
    IC->>IC: Validate form data
    
    alt Form is valid
        IC->>UC: Create/find user by email
        UC->>DB: Save/update user
        DB->>UC: Return user
        UC->>IC: Return user object
        
        IC->>DB: Save inquiry
        DB->>IC: Return inquiry
        
        IC->>E: Send confirmation email
        E->>C: Email sent
        
        IC->>A: Send admin notification
        IC->>W: Return success response
        W->>C: Show success message
    else Form is invalid
        IC->>W: Return validation errors
        W->>C: Show error messages
    end
```

### 4.2 Real-time Chat Communication

```mermaid
sequenceDiagram
    participant C as Customer
    participant CF as Customer Frontend
    participant CC as ChatController
    participant DB as Database
    participant P as Pusher
    participant AF as Admin Frontend
    participant A as Admin
    
    C->>CF: Type message
    CF->>CC: POST /chat/send
    CC->>DB: Save message
    DB->>CC: Return message
    
    CC->>P: Broadcast MessageSent event
    P->>AF: Push notification
    AF->>A: Show new message notification
    
    CC->>CF: Return success
    CF->>C: Show message sent
    
    A->>AF: Click on chat
    AF->>CC: GET /chat/messages
    CC->>DB: Fetch messages
    DB->>CC: Return messages
    CC->>AF: Return message list
    AF->>A: Display chat history
    
    A->>AF: Type reply
    AF->>CC: POST /admin/chat/reply
    CC->>DB: Save admin message
    DB->>CC: Return message
    
    CC->>P: Broadcast AdminReply event
    P->>CF: Push notification
    CF->>C: Show new admin message
```

### 4.3 Contract Generation and Payment

```mermaid
sequenceDiagram
    participant A as Admin
    participant AC as AdminController
    participant PC as ProjectController
    participant CC as ContractController
    participant DB as Database
    participant PDF as PDFService
    participant PS as PaymentService
    participant C as Customer
    
    A->>AC: Create contract from project
    AC->>PC: Get project details
    PC->>DB: Fetch project
    DB->>PC: Return project data
    PC->>AC: Return project
    
    AC->>CC: Generate contract
    CC->>CC: Generate contract number
    CC->>DB: Save contract
    DB->>CC: Return contract
    
    CC->>PDF: Generate PDF contract
    PDF->>CC: Return PDF file
    CC->>AC: Return contract with PDF
    AC->>A: Show contract created
    
    A->>AC: Send contract to customer
    AC->>C: Email contract PDF
    
    C->>PS: Make payment
    PS->>CC: Record payment
    CC->>DB: Save payment record
    DB->>CC: Return payment
    
    CC->>AC: Update contract status
    AC->>A: Show payment received
```

---

*Diagram UML ini memberikan visualisasi yang komprehensif tentang struktur, alur kerja, dan interaksi dalam sistem Ardfya v2, memudahkan pemahaman arsitektur dan proses bisnis aplikasi.*
