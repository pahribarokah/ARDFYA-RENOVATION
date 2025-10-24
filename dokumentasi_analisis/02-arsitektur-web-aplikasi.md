# 🏗️ Arsitektur Web Aplikasi ARDFYA v2.1

## 📋 Overview Arsitektur

ARDFYA v2.1 menggunakan arsitektur **3-Tier Architecture** dengan pola **MVC (Model-View-Controller)** yang diimplementasikan menggunakan Laravel framework. Sistem ini dirancang untuk memberikan skalabilitas, maintainability, dan performance yang optimal.

## 🎯 Diagram Arsitektur Sistem

```mermaid
graph TB
    subgraph "Client Layer (Presentation Tier)"
        A[Web Browser]
        B[Mobile Browser]
        C[Tablet Browser]
    end
    
    subgraph "Application Layer (Logic Tier)"
        subgraph "Frontend Components"
            D[Blade Templates]
            E[TailwindCSS]
            F[Alpine.js]
            G[Bootstrap 5]
        end
        
        subgraph "Laravel Framework"
            H[Routes]
            I[Middleware]
            J[Controllers]
            K[Services]
            L[Models]
        end
        
        subgraph "Real-time Layer"
            M[Laravel Echo]
            N[Pusher Service]
            O[Broadcasting]
        end
    end
    
    subgraph "Data Layer (Data Tier)"
        P[(SQLite/MySQL Database)]
        Q[File Storage]
        R[Session Storage]
        S[Cache Storage]
    end
    
    subgraph "External Services"
        T[Email Service]
        U[PDF Generator]
        V[File Upload Service]
    end
    
    A --> D
    B --> D
    C --> D
    
    D --> H
    E --> D
    F --> D
    G --> D
    
    H --> I
    I --> J
    J --> K
    K --> L
    
    M --> N
    N --> O
    O --> J
    
    L --> P
    J --> Q
    I --> R
    K --> S
    
    J --> T
    K --> U
    J --> V
```

## 🔧 Komponen Arsitektur Detail

### **1. Client Layer (Presentation Tier)**

#### **Web Browser Support**
- **Desktop Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile Browsers**: Mobile Chrome, Mobile Safari
- **Tablet Support**: iPad, Android tablets
- **Responsive Design**: Automatic adaptation untuk semua screen sizes

#### **Frontend Technologies**
```mermaid
graph LR
    A[HTML5] --> B[Blade Templates]
    C[CSS3] --> D[TailwindCSS]
    E[JavaScript] --> F[Alpine.js]
    G[Components] --> H[Bootstrap 5]
    
    B --> I[Dynamic Content]
    D --> J[Utility Classes]
    F --> K[Reactive Components]
    H --> L[UI Components]
```

### **2. Application Layer (Logic Tier)**

#### **A. Frontend Framework Stack**

##### **Blade Templating Engine**
- **Fungsi**: Server-side rendering dengan dynamic content
- **Fitur**: Template inheritance, components, directives
- **Integrasi**: Seamless dengan Laravel backend

##### **TailwindCSS Framework**
- **Fungsi**: Utility-first CSS framework
- **Fitur**: Responsive design, custom components
- **Optimisasi**: Purge unused CSS untuk performance

##### **Alpine.js Framework**
- **Fungsi**: Lightweight JavaScript framework
- **Fitur**: Reactive data binding, component state management
- **Integrasi**: Perfect untuk Laravel Blade templates

##### **Bootstrap 5 Components**
- **Fungsi**: Pre-built UI components
- **Fitur**: Modal, dropdown, navigation, forms
- **Customization**: Themed untuk ARDFYA branding

#### **B. Laravel Backend Architecture**

```mermaid
graph TD
    A[HTTP Request] --> B[Route Handler]
    B --> C{Middleware Check}
    C -->|Authenticated| D[Controller]
    C -->|Not Authenticated| E[Redirect to Login]
    
    D --> F[Service Layer]
    F --> G[Model Layer]
    G --> H[(Database)]
    
    G --> I[Response Data]
    I --> J[View Rendering]
    J --> K[HTTP Response]
    
    subgraph "Middleware Stack"
        L[CSRF Protection]
        M[Authentication]
        N[Admin Middleware]
        O[Rate Limiting]
    end
    
    C --> L
    L --> M
    M --> N
    N --> O
```

##### **Route Management**
- **Web Routes**: `/routes/web.php` - Main application routes
- **API Routes**: `/routes/api.php` - AJAX dan real-time endpoints
- **Route Groups**: Organized by functionality dan middleware

##### **Middleware System**
- **AdminMiddleware**: Role-based access control
- **Auth Middleware**: Authentication verification
- **CSRF Protection**: Security against cross-site attacks
- **Rate Limiting**: API request throttling

##### **Controller Architecture**
```mermaid
graph LR
    A[HomeController] --> B[Public Pages]
    C[Admin Controllers] --> D[Admin Functions]
    E[Customer Controllers] --> F[Customer Functions]
    G[Auth Controllers] --> H[Authentication]
    
    subgraph "Admin Controllers"
        I[DashboardController]
        J[InquiryController]
        K[ProjectController]
        L[ContractController]
        M[PortfolioController]
        N[MessageController]
    end
    
    subgraph "Customer Controllers"
        O[DashboardController]
        P[ProfileController]
        Q[ProjectController]
    end
```

##### **Service Layer Pattern**
- **Business Logic**: Separated dari controllers
- **Reusability**: Shared logic across controllers
- **Testing**: Easier unit testing
- **Maintenance**: Better code organization

##### **Model Layer (Eloquent ORM)**
- **Active Record Pattern**: Object-relational mapping
- **Relationships**: Defined model relationships
- **Scopes**: Reusable query logic
- **Mutators/Accessors**: Data transformation

#### **C. Real-time Communication Layer**

```mermaid
sequenceDiagram
    participant C as Customer
    participant L as Laravel App
    participant P as Pusher Service
    participant A as Admin
    
    C->>L: Send Chat Message
    L->>L: Store in Database
    L->>P: Broadcast Event
    P->>A: Real-time Notification
    A->>L: Send Reply
    L->>L: Store Reply
    L->>P: Broadcast Reply
    P->>C: Real-time Message
```

##### **Laravel Echo Integration**
- **WebSocket Client**: Real-time communication
- **Event Broadcasting**: Server-to-client messaging
- **Channel Authentication**: Secure private channels

##### **Pusher Service**
- **Real-time Delivery**: Instant message delivery
- **Scalability**: Handle multiple concurrent connections
- **Reliability**: Message delivery guarantee

### **3. Data Layer (Data Tier)**

#### **Database Architecture**

```mermaid
erDiagram
    USERS ||--o{ INQUIRIES : "submits"
    USERS ||--o{ PROJECTS : "owns"
    USERS ||--o{ CONTRACTS : "signs"
    USERS ||--o{ CHATS : "participates"
    
    SERVICES ||--o{ INQUIRIES : "requested_for"
    SERVICES ||--o{ PROJECTS : "used_in"
    
    INQUIRIES ||--o| PROJECTS : "converts_to"
    PROJECTS ||--o| CONTRACTS : "generates"
    
    PROJECTS ||--o{ CHATS : "discusses"
    USERS ||--o{ NOTIFICATIONS : "receives"
    
    PORTFOLIOS {
        id int
        title string
        description text
        category string
        image_path string
        is_featured boolean
    }
```

#### **Storage Systems**

##### **Database Storage**
- **Development**: SQLite (portable, zero-config)
- **Production**: MySQL/PostgreSQL (scalable, robust)
- **Migrations**: Version control untuk database schema
- **Seeders**: Sample data untuk development

##### **File Storage**
- **Local Storage**: Development file storage
- **Cloud Storage**: Production file storage (S3, etc.)
- **Image Processing**: Automatic optimization
- **Security**: File type validation

##### **Session & Cache**
- **Session Storage**: User session management
- **Cache Storage**: Performance optimization
- **Redis Support**: Advanced caching (optional)

## 🔄 Data Flow Architecture

### **1. Request-Response Cycle**

```mermaid
sequenceDiagram
    participant B as Browser
    participant R as Routes
    participant M as Middleware
    participant C as Controller
    participant S as Service
    participant Mo as Model
    participant D as Database
    participant V as View
    
    B->>R: HTTP Request
    R->>M: Route to Middleware
    M->>M: Authentication Check
    M->>C: Forward to Controller
    C->>S: Business Logic
    S->>Mo: Data Operations
    Mo->>D: Database Query
    D->>Mo: Query Results
    Mo->>S: Processed Data
    S->>C: Business Results
    C->>V: Render View
    V->>B: HTTP Response
```

### **2. Real-time Communication Flow**

```mermaid
graph TD
    A[User Action] --> B[Controller Method]
    B --> C[Store in Database]
    B --> D[Broadcast Event]
    D --> E[Pusher Service]
    E --> F[Connected Clients]
    F --> G[Update UI]
    
    subgraph "Event Types"
        H[New Chat Message]
        I[Inquiry Update]
        J[Project Progress]
        K[Contract Status]
    end
    
    D --> H
    D --> I
    D --> J
    D --> K
```

## 🛡️ Security Architecture

### **Authentication & Authorization**

```mermaid
graph TD
    A[User Login] --> B{Credentials Valid?}
    B -->|Yes| C[Create Session]
    B -->|No| D[Login Failed]
    
    C --> E{User Role?}
    E -->|Admin| F[Admin Dashboard]
    E -->|Customer| G[Customer Dashboard]
    
    F --> H[AdminMiddleware]
    G --> I[Auth Middleware]
    
    H --> J[Admin Functions]
    I --> K[Customer Functions]
    
    subgraph "Security Layers"
        L[CSRF Protection]
        M[Input Validation]
        N[SQL Injection Prevention]
        O[XSS Protection]
    end
    
    J --> L
    K --> L
    L --> M
    M --> N
    N --> O
```

### **Security Features**
- **CSRF Protection**: Built-in Laravel protection
- **Input Validation**: Form request validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping
- **File Upload Security**: Type dan size validation
- **Rate Limiting**: API request throttling

## 📊 Performance Architecture

### **Optimization Strategies**

```mermaid
graph LR
    A[Performance Optimization] --> B[Frontend Optimization]
    A --> C[Backend Optimization]
    A --> D[Database Optimization]
    
    B --> E[Asset Minification]
    B --> F[Image Optimization]
    B --> G[Lazy Loading]
    
    C --> H[Query Optimization]
    C --> I[Caching Strategy]
    C --> J[Code Optimization]
    
    D --> K[Index Optimization]
    D --> L[Query Caching]
    D --> M[Connection Pooling]
```

### **Caching Strategy**
- **View Caching**: Compiled Blade templates
- **Route Caching**: Optimized route resolution
- **Config Caching**: Configuration optimization
- **Query Caching**: Database query results
- **Asset Caching**: Static file caching

## 🚀 Deployment Architecture

### **Development Environment**
```
Local Development → SQLite → File Storage → Local Server
```

### **Production Environment**
```
Load Balancer → Web Servers → MySQL/PostgreSQL → Cloud Storage
```

### **CI/CD Pipeline**
```mermaid
graph LR
    A[Code Commit] --> B[Automated Testing]
    B --> C[Build Process]
    C --> D[Deployment]
    D --> E[Health Check]
    
    subgraph "Testing Stages"
        F[Unit Tests]
        G[Integration Tests]
        H[Feature Tests]
    end
    
    B --> F
    B --> G
    B --> H
```

## 📈 Scalability Considerations

### **Horizontal Scaling**
- **Load Balancing**: Multiple web server instances
- **Database Clustering**: Master-slave configuration
- **File Storage**: Distributed storage systems
- **Cache Distribution**: Redis clustering

### **Vertical Scaling**
- **Server Resources**: CPU, RAM, Storage upgrades
- **Database Optimization**: Query performance tuning
- **Application Optimization**: Code efficiency improvements

---

**Arsitektur ARDFYA v2.1** dirancang untuk memberikan **performance**, **scalability**, dan **maintainability** yang optimal untuk bisnis konstruksi dan arsitektur modern. 🏗️
