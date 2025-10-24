# Diagram UML Lengkap - ARDFYA v2.1

## 1. Gambaran Umum

Dokumentasi ini menyediakan diagram UML lengkap untuk sistem ARDFYA v2.1 yang mencakup semua aspek sistem manajemen konstruksi dan arsitektur. Diagram-diagram ini dibuat berdasarkan dokumentasi yang telah diperbarui dan mencerminkan fitur-fitur terbaru termasuk Portfolio Management System.

## 2. Jenis Diagram UML

### 2.1 Use Case Diagram
Menggambarkan interaksi antara aktor (Guest, Customer, Admin) dengan sistem dan fitur-fitur yang tersedia.

**File**: `use-case-diagram.puml`

**Aktor:**
- **Guest**: Pengunjung website yang belum login
- **Customer**: Pelanggan yang sudah terdaftar dan login
- **Admin**: Administrator sistem dengan akses penuh

**Use Cases:**
- Guest: Browse homepage, view portfolio, submit inquiry, register, login
- Customer: Manage profile, submit inquiry, track projects, chat with admin, view contracts
- Admin: Manage customers, inquiries, projects, contracts, portfolios, chat with customers

### 2.2 Class Diagram
Menggambarkan struktur kelas, atribut, method, dan relasi antar kelas dalam sistem.

**File**: `class-diagram.puml`

**Main Classes:**
- User (Customer/Admin)
- Service
- Inquiry
- Project
- Contract
- Portfolio (NEW v2.1)
- Message
- Chat

**Relationships:**
- User has many Inquiries
- User has many Projects
- User has many Messages
- Service has many Inquiries
- Inquiry belongs to Service and User
- Project belongs to User and Service
- Contract belongs to Project
- Portfolio standalone entity
- Message belongs to User

### 2.3 Activity Diagram
Menggambarkan alur proses bisnis untuk setiap fitur utama sistem.

**File**: `activity-diagrams.puml`

**Diagrams Included:**
1. **Customer Registration & Login Process**
2. **Inquiry Submission Process**
3. **Admin Inquiry Management Process**
4. **Project Creation & Management Process**
5. **Contract Generation & Management Process**
6. **Portfolio Management Process (NEW v2.1)**
7. **Real-time Chat Process**
8. **Payment Tracking Process**
9. **Admin Dashboard Analytics Process**
10. **Customer Project Monitoring Process**

### 2.4 Sequence Diagram
Menggambarkan interaksi antar objek dalam urutan waktu untuk setiap skenario.

**File**: `sequence-diagrams.puml`

**Diagrams Included:**
1. **Customer Registration Sequence**
2. **Customer Login Sequence**
3. **Inquiry Submission Sequence**
4. **Admin Inquiry Review Sequence**
5. **Project Creation Sequence**
6. **Contract Generation Sequence**
7. **Portfolio Creation Sequence (NEW v2.1)**
8. **Portfolio Display on Homepage Sequence (NEW v2.1)**
9. **Real-time Chat Message Sequence**
10. **Payment Recording Sequence**
11. **Admin Dashboard Data Loading Sequence**
12. **Customer Project Status Update Sequence**

## 3. Sistem Architecture Overview

### 3.1 Layered Architecture
```
┌─────────────────────────────────────┐
│           Presentation Layer        │
│  (Blade Views, Controllers, Routes) │
├─────────────────────────────────────┤
│            Business Layer           │
│     (Models, Services, Logic)       │
├─────────────────────────────────────┤
│             Data Layer              │
│    (Database, Migrations, Seeds)    │
└─────────────────────────────────────┘
```

### 3.2 MVC Pattern Implementation
- **Model**: Eloquent models dengan relationships
- **View**: Blade templates dengan component system
- **Controller**: Resource controllers dengan middleware

### 3.3 Key Design Patterns
- **Repository Pattern**: Data access abstraction
- **Observer Pattern**: Model events dan listeners
- **Factory Pattern**: Model factories untuk testing
- **Middleware Pattern**: Authentication dan authorization
- **Service Pattern**: Business logic encapsulation

## 4. Database Entity Relationships

### 4.1 Core Entities
```
User (1) ──── (M) Inquiry
User (1) ──── (M) Project
User (1) ──── (M) Message
User (1) ──── (M) Contract

Service (1) ──── (M) Inquiry
Service (1) ──── (M) Project

Inquiry (1) ──── (1) Project
Project (1) ──── (1) Contract

Portfolio (standalone entity)
```

### 4.2 New Portfolio Entity (v2.1)
```
Portfolio:
- id (PK)
- title
- description
- category
- image_path
- client_name
- location
- completion_date
- project_value
- is_featured
- is_active
- ordering
- timestamps
```

## 5. Business Process Flows

### 5.1 Customer Journey
```
Guest → Registration → Login → Inquiry → Project → Contract → Completion
```

### 5.2 Admin Workflow
```
Dashboard → Inquiry Review → Project Creation → Progress Tracking → Contract Management → Completion
```

### 5.3 Portfolio Management (NEW v2.1)
```
Admin → Portfolio Creation → Image Upload → Category Assignment → Featured Setting → Homepage Display
```

## 6. Security & Authorization

### 6.1 Authentication Flow
- Multi-guard authentication (web, admin)
- Session-based authentication
- CSRF protection
- Password hashing with bcrypt

### 6.2 Authorization Matrix
```
Feature          | Guest | Customer | Admin
Homepage         |   ✓   |    ✓     |   ✓
Portfolio View   |   ✓   |    ✓     |   ✓
Inquiry Submit   |   ✓   |    ✓     |   ✓
Project Track    |   ✗   |    ✓     |   ✓
Admin Panel      |   ✗   |    ✗     |   ✓
Portfolio CRUD   |   ✗   |    ✗     |   ✓
```

## 7. Real-time Features

### 7.1 Chat System Architecture
```
Customer ←→ Laravel Echo ←→ Pusher ←→ Admin
```

### 7.2 Event Broadcasting
- MessageSent event
- InquiryReceived event
- ProjectUpdated event
- PaymentReceived event

## 8. API Endpoints (Internal)

### 8.1 Admin API Routes
- `/admin/api/inquiries` - Get inquiries data
- `/admin/api/projects` - Get projects data
- `/admin/api/customers` - Get customers data

### 8.2 Chat API Routes
- `/chat/messages` - Get chat messages
- `/chat/send` - Send message
- `/chat/read` - Mark as read

## 9. File Structure Mapping

### 9.1 Controllers Hierarchy
```
Controllers/
├── HomeController (Public pages)
├── InquiryController (Customer inquiries)
├── MessageController (Customer chat)
├── ContactController (Contact form)
└── Admin/
    ├── DashboardController
    ├── InquiryController
    ├── ProjectController
    ├── ContractController
    ├── CustomerController
    ├── PortfolioController (NEW v2.1)
    └── MessageController
```

### 9.2 Models Hierarchy
```
Models/
├── User (Customer & Admin)
├── Service
├── Inquiry
├── Project
├── Contract
├── Portfolio (NEW v2.1)
└── Message
```

## 10. Integration Points

### 10.1 External Services
- **Pusher**: Real-time messaging
- **Email Service**: Notifications
- **File Storage**: Image uploads
- **PDF Generation**: Contract documents

### 10.2 Internal Integrations
- **Portfolio → Homepage**: Dynamic display
- **Inquiry → Project**: Conversion workflow
- **Project → Contract**: Generation workflow
- **User → Multiple entities**: Relationship management

## 11. Diagram Files Summary

### 11.1 PlantUML Files Created

**1. use-case-diagram.puml**
- 55+ use cases covering all system features
- 3 main actors (Guest, Customer, Admin)
- Include/extend relationships
- Complete coverage of v2.1 features including Portfolio Management

**2. class-diagram.puml**
- 8 main classes with full attributes and methods
- Complete relationships mapping
- Portfolio class as new entity in v2.1
- Proper inheritance and associations

**3. activity-diagrams.puml**
- 10+ detailed activity diagrams
- Complete business process flows
- Decision points and parallel activities
- New Portfolio Management activities
- Real-time chat processes
- Admin dashboard analytics

**4. sequence-diagrams.puml**
- 12+ detailed sequence diagrams
- Complete interaction flows
- Database operations
- Email notifications
- Real-time messaging
- Portfolio creation and display
- Payment processing

### 11.2 How to Use These Diagrams

**For Development:**
```bash
# Install PlantUML
npm install -g plantuml

# Generate diagrams
plantuml dokumentasi/use-case-diagram.puml
plantuml dokumentasi/class-diagram.puml
plantuml dokumentasi/activity-diagrams.puml
plantuml dokumentasi/sequence-diagrams.puml
```

**For Documentation:**
- Use diagrams in technical specifications
- Include in developer onboarding materials
- Reference for system architecture discussions
- Use for stakeholder presentations

**For Maintenance:**
- Update diagrams when adding new features
- Use for debugging complex workflows
- Reference for database schema changes
- Guide for API endpoint modifications

### 11.3 Diagram Relationships

```
Use Case Diagram ──┐
                   ├── System Requirements
Class Diagram ─────┤
                   ├── Implementation Guide
Activity Diagram ──┤
                   ├── Business Logic
Sequence Diagram ──┘
```

### 11.4 Version Control

**Current Version**: v2.1
**Last Updated**: After Portfolio Management integration and code cleanup
**Next Update**: When new features are added or existing processes change

**Change Log:**
- v2.1: Added Portfolio Management diagrams
- v2.1: Updated all diagrams to reflect code cleanup
- v2.1: Enhanced sequence diagrams with database operations
- v2.1: Added real-time features documentation

---

*Diagram UML ini memberikan pandangan komprehensif tentang sistem ARDFYA v2.1 dan dapat digunakan sebagai referensi utama untuk pengembangan, maintenance, dokumentasi teknis, dan presentasi stakeholder. Semua diagram telah diperbarui untuk mencerminkan fitur-fitur terbaru dan optimisasi yang dilakukan pada sistem.*
