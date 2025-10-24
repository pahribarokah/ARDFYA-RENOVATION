# Database dan Model - Aplikasi Ardfya v2

## 1. Gambaran Umum Database

Aplikasi Ardfya v2 menggunakan database relational dengan 10 tabel utama yang saling terhubung untuk mengelola sistem konstruksi dan arsitektur. Database dirancang dengan prinsip normalisasi untuk menghindari redundansi data dan memastikan integritas referensial.

### 1.1 Database Configuration
- **Development**: SQLite (database/database.sqlite)
- **Production**: MySQL/PostgreSQL
- **ORM**: Eloquent ORM
- **Migration**: Laravel Migration System
- **Seeding**: Database Seeders dengan Faker

## 2. Struktur Tabel Database

### 2.1 Tabel Users
**Tujuan**: Menyimpan data pengguna (admin dan customer)

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik pengguna |
| name | VARCHAR(255) | NOT NULL | Nama lengkap pengguna |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email pengguna |
| email_verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password terenkripsi |
| phone | VARCHAR(255) | NULLABLE | Nomor telepon |
| address | TEXT | NULLABLE | Alamat lengkap |
| role | ENUM | DEFAULT 'customer' | Role: 'customer', 'admin' |
| remember_token | VARCHAR(100) | NULLABLE | Token remember me |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.2 Tabel Services
**Tujuan**: Menyimpan data layanan yang ditawarkan

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik layanan |
| name | VARCHAR(255) | NOT NULL | Nama layanan |
| slug | VARCHAR(255) | UNIQUE | URL-friendly identifier |
| description | TEXT | NOT NULL | Deskripsi lengkap layanan |
| short_description | TEXT | NULLABLE | Deskripsi singkat |
| image_path | VARCHAR(255) | NULLABLE | Path gambar layanan |
| icon | VARCHAR(255) | NOT NULL | Icon layanan |
| price_range | VARCHAR(255) | NULLABLE | Range harga |
| is_featured | BOOLEAN | DEFAULT FALSE | Apakah layanan unggulan |
| is_active | BOOLEAN | DEFAULT TRUE | Status aktif layanan |
| ordering | INTEGER | DEFAULT 0 | Urutan tampilan |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.3 Tabel Inquiries
**Tujuan**: Menyimpan pertanyaan/inquiry dari customer

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik inquiry |
| user_id | BIGINT | FOREIGN KEY | Referensi ke users.id |
| service_id | BIGINT | FOREIGN KEY | Referensi ke services.id |
| name | VARCHAR(255) | NOT NULL | Nama customer |
| email | VARCHAR(255) | NOT NULL | Email customer |
| phone | VARCHAR(255) | NOT NULL | Nomor telepon |
| property_type | VARCHAR(255) | NULLABLE | Jenis properti |
| address | TEXT | NOT NULL | Alamat proyek |
| area_size | INTEGER | NULLABLE | Luas area (m²) |
| budget | DECIMAL(15,2) | NULLABLE | Budget yang dimiliki |
| description | TEXT | NOT NULL | Deskripsi kebutuhan |
| status | VARCHAR(255) | DEFAULT 'pending' | Status inquiry |
| admin_notes | TEXT | NULLABLE | Catatan admin |
| start_date | DATE | NULLABLE | Tanggal mulai diinginkan |
| schedule_flexibility | VARCHAR(255) | NULLABLE | Fleksibilitas jadwal |
| current_condition | TEXT | NULLABLE | Kondisi saat ini |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.4 Tabel Projects
**Tujuan**: Menyimpan data proyek yang sedang/sudah dikerjakan

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik proyek |
| user_id | BIGINT | FOREIGN KEY | Referensi ke users.id |
| service_id | BIGINT | FOREIGN KEY | Referensi ke services.id |
| inquiry_id | BIGINT | FOREIGN KEY, NULLABLE | Referensi ke inquiries.id |
| name | VARCHAR(255) | NOT NULL | Nama proyek |
| description | TEXT | NULLABLE | Deskripsi proyek |
| status | VARCHAR(255) | DEFAULT 'planning' | Status proyek |
| start_date | DATE | NULLABLE | Tanggal mulai |
| expected_end_date | DATE | NULLABLE | Tanggal selesai yang diharapkan |
| actual_end_date | DATE | NULLABLE | Tanggal selesai aktual |
| end_date | DATE | NULLABLE | Tanggal selesai |
| address | TEXT | NOT NULL | Alamat proyek |
| total_cost | DECIMAL(15,2) | NULLABLE | Total biaya proyek |
| budget | DECIMAL(15,2) | NULLABLE | Budget yang dialokasikan |
| thumbnail | VARCHAR(255) | NULLABLE | Gambar thumbnail |
| category | VARCHAR(255) | NULLABLE | Kategori proyek |
| is_featured | BOOLEAN | DEFAULT FALSE | Apakah proyek unggulan |
| progress_percentage | INTEGER | DEFAULT 0 | Persentase progress (0-100) |
| notes | TEXT | NULLABLE | Catatan proyek |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.5 Tabel Contracts
**Tujuan**: Menyimpan data kontrak proyek

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik kontrak |
| project_id | BIGINT | FOREIGN KEY | Referensi ke projects.id |
| user_id | BIGINT | FOREIGN KEY | Referensi ke users.id |
| contract_number | VARCHAR(255) | UNIQUE | Nomor kontrak |
| start_date | DATE | NOT NULL | Tanggal mulai kontrak |
| end_date | DATE | NOT NULL | Tanggal berakhir kontrak |
| amount | DECIMAL(15,2) | NOT NULL | Nilai kontrak |
| paid_amount | DECIMAL(15,2) | DEFAULT 0 | Jumlah yang sudah dibayar |
| contract_file | VARCHAR(255) | NULLABLE | File kontrak |
| payment_status | VARCHAR(255) | DEFAULT 'unpaid' | Status pembayaran |
| contract_status | VARCHAR(255) | DEFAULT 'active' | Status kontrak |
| last_payment_date | DATE | NULLABLE | Tanggal pembayaran terakhir |
| payment_method | VARCHAR(255) | NULLABLE | Metode pembayaran |
| installments | INTEGER | DEFAULT 1 | Jumlah cicilan |
| notes | TEXT | NULLABLE | Catatan kontrak |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.6 Tabel Contract_Payments
**Tujuan**: Menyimpan riwayat pembayaran kontrak

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik pembayaran |
| contract_id | BIGINT | FOREIGN KEY | Referensi ke contracts.id |
| user_id | BIGINT | FOREIGN KEY | Referensi ke users.id |
| amount | DECIMAL(15,2) | NOT NULL | Jumlah pembayaran |
| payment_date | DATE | NOT NULL | Tanggal pembayaran |
| payment_method | VARCHAR(255) | NOT NULL | Metode pembayaran |
| transaction_id | VARCHAR(255) | NULLABLE | ID transaksi |
| receipt_number | VARCHAR(255) | NULLABLE | Nomor kwitansi |
| notes | TEXT | NULLABLE | Catatan pembayaran |
| receipt_file | VARCHAR(255) | NULLABLE | File bukti pembayaran |
| status | VARCHAR(255) | DEFAULT 'confirmed' | Status pembayaran |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.7 Tabel Messages
**Tujuan**: Menyimpan pesan komunikasi antara admin dan customer

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik pesan |
| user_id | BIGINT | FOREIGN KEY | Referensi ke users.id |
| project_id | BIGINT | FOREIGN KEY, NULLABLE | Referensi ke projects.id |
| inquiry_id | BIGINT | FOREIGN KEY, NULLABLE | Referensi ke inquiries.id |
| message | TEXT | NOT NULL | Isi pesan |
| is_from_admin | BOOLEAN | DEFAULT FALSE | Apakah dari admin |
| is_read | BOOLEAN | DEFAULT FALSE | Apakah sudah dibaca |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.8 Tabel Chats
**Tujuan**: Sistem chat real-time antara admin dan customer

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik chat |
| customer_id | BIGINT | FOREIGN KEY | Referensi ke users.id (customer) |
| admin_id | BIGINT | FOREIGN KEY, NULLABLE | Referensi ke users.id (admin) |
| message | TEXT | NOT NULL | Isi pesan |
| is_from_admin | BOOLEAN | DEFAULT FALSE | Apakah dari admin |
| is_read | BOOLEAN | DEFAULT FALSE | Apakah sudah dibaca |
| file_url | VARCHAR(255) | NULLABLE | URL file attachment |
| file_name | VARCHAR(255) | NULLABLE | Nama file |
| file_type | VARCHAR(255) | NULLABLE | Tipe file |
| file_size | INTEGER | NULLABLE | Ukuran file (bytes) |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.9 Tabel Project_Images
**Tujuan**: Menyimpan gambar-gambar proyek

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik gambar |
| project_id | BIGINT | FOREIGN KEY | Referensi ke projects.id |
| image_path | VARCHAR(255) | NOT NULL | Path file gambar |
| caption | TEXT | NULLABLE | Caption gambar |
| ordering | INTEGER | DEFAULT 0 | Urutan tampilan |
| is_before_image | BOOLEAN | DEFAULT FALSE | Gambar sebelum |
| is_after_image | BOOLEAN | DEFAULT FALSE | Gambar sesudah |
| is_featured | BOOLEAN | DEFAULT FALSE | Gambar unggulan |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 2.10 Tabel Admins
**Tujuan**: Menyimpan data admin terpisah (opsional)

| Field | Type | Constraint | Description |
|-------|------|------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik admin |
| name | VARCHAR(255) | NOT NULL | Nama admin |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email admin |
| email_verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password terenkripsi |
| remember_token | VARCHAR(100) | NULLABLE | Token remember me |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

## 3. Relasi Antar Tabel

### 3.1 Entity Relationship Diagram (ERD)
```
Users (1) ----< (M) Inquiries
Users (1) ----< (M) Projects  
Users (1) ----< (M) Contracts
Users (1) ----< (M) Messages
Users (1) ----< (M) Chats
Users (1) ----< (M) Contract_Payments

Services (1) ----< (M) Inquiries
Services (1) ----< (M) Projects

Inquiries (1) ----< (1) Projects
Inquiries (1) ----< (M) Messages

Projects (1) ----< (1) Contracts
Projects (1) ----< (M) Project_Images
Projects (1) ----< (M) Messages

Contracts (1) ----< (M) Contract_Payments
```

### 3.2 Relasi Detail

#### User Relationships
- **User hasMany Inquiries**: Satu user dapat memiliki banyak inquiry
- **User hasMany Projects**: Satu user dapat memiliki banyak proyek
- **User hasMany Contracts**: Satu user dapat memiliki banyak kontrak
- **User hasMany Messages**: Satu user dapat mengirim banyak pesan
- **User hasMany ContractPayments**: Satu user dapat melakukan banyak pembayaran

#### Service Relationships
- **Service hasMany Inquiries**: Satu layanan dapat memiliki banyak inquiry
- **Service hasMany Projects**: Satu layanan dapat memiliki banyak proyek

#### Project Relationships
- **Project belongsTo User**: Setiap proyek dimiliki oleh satu user
- **Project belongsTo Service**: Setiap proyek terkait dengan satu layanan
- **Project belongsTo Inquiry**: Setiap proyek dapat berasal dari satu inquiry
- **Project hasOne Contract**: Setiap proyek dapat memiliki satu kontrak
- **Project hasMany ProjectImages**: Setiap proyek dapat memiliki banyak gambar
- **Project hasMany Messages**: Setiap proyek dapat memiliki banyak pesan

#### Contract Relationships
- **Contract belongsTo Project**: Setiap kontrak terkait dengan satu proyek
- **Contract belongsTo User**: Setiap kontrak dimiliki oleh satu user
- **Contract hasMany ContractPayments**: Setiap kontrak dapat memiliki banyak pembayaran

## 4. Model Eloquent

### 4.1 Model User
```php
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'role'
    ];
    
    // Relationships
    public function projects(): HasMany
    public function inquiries(): HasMany  
    public function messages(): HasMany
    public function contracts(): HasMany
    
    // Methods
    public function isAdmin(): bool
}
```

### 4.2 Model Service
```php
class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'short_description',
        'image_path', 'icon', 'price_range', 'is_featured',
        'is_active', 'ordering'
    ];
    
    // Relationships
    public function projects(): HasMany
    public function inquiries(): HasMany
}
```

### 4.3 Model Project
```php
class Project extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'inquiry_id', 'name',
        'description', 'status', 'start_date', 'expected_end_date',
        'actual_end_date', 'end_date', 'address', 'total_cost',
        'budget', 'thumbnail', 'category', 'is_featured',
        'progress_percentage', 'notes'
    ];
    
    // Relationships
    public function user(): BelongsTo
    public function service(): BelongsTo
    public function inquiry(): BelongsTo
    public function contract(): HasOne
    public function projectImages(): HasMany
    public function messages(): HasMany
}
```

### 4.4 Model Contract
```php
class Contract extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'contract_number',
        'start_date', 'end_date', 'amount', 'paid_amount',
        'contract_file', 'payment_status', 'contract_status',
        'last_payment_date', 'payment_method', 'installments', 'notes'
    ];
    
    // Relationships
    public function project(): BelongsTo
    public function user(): BelongsTo
    public function payments(): HasMany
    
    // Accessors
    public function getRemainingAmountAttribute()
    public function getPaymentPercentageAttribute()
    
    // Static Methods
    public static function generateContractNumber(): string
}
```

## 5. Indexes dan Optimasi

### 5.1 Database Indexes
```sql
-- Primary Keys (otomatis)
-- Foreign Key Indexes
CREATE INDEX idx_inquiries_user_id ON inquiries(user_id);
CREATE INDEX idx_inquiries_service_id ON inquiries(service_id);
CREATE INDEX idx_projects_user_id ON projects(user_id);
CREATE INDEX idx_projects_service_id ON projects(service_id);
CREATE INDEX idx_contracts_project_id ON contracts(project_id);
CREATE INDEX idx_messages_user_id ON messages(user_id);

-- Performance Indexes
CREATE INDEX idx_services_active ON services(is_active);
CREATE INDEX idx_projects_status ON projects(status);
CREATE INDEX idx_contracts_status ON contracts(contract_status);
```

### 5.2 Query Optimization
- **Eager Loading**: Menggunakan `with()` untuk menghindari N+1 queries
- **Selective Fields**: Menggunakan `select()` untuk mengambil field yang diperlukan saja
- **Pagination**: Menggunakan `paginate()` untuk data yang banyak
- **Caching**: Cache query yang sering digunakan

---

*Database ini dirancang untuk mendukung skalabilitas dan performa optimal dengan normalisasi yang tepat dan indexing yang efisien.*
