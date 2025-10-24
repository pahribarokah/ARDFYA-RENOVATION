# Portfolio Management System - Ardfya v2.1

## 1. Gambaran Umum

Portfolio Management System adalah fitur baru yang diperkenalkan di Ardfya v2.1 untuk mengelola dan menampilkan portfolio proyek secara dinamis. Sistem ini terintegrasi penuh dengan homepage dan menyediakan interface admin yang komprehensif.

## 2. Fitur Portfolio

### 2.1 Admin Portfolio Management

**Lokasi**: `/admin/portfolios`

**Fitur CRUD Lengkap:**
- ✅ **Create**: Membuat portfolio baru
- ✅ **Read**: Melihat daftar dan detail portfolio
- ✅ **Update**: Edit portfolio existing
- ✅ **Delete**: Hapus portfolio

**Form Fields:**
```php
- title (required): Judul portfolio
- description (required): Deskripsi lengkap
- category (required): Kategori portfolio
- image_path (optional): Upload gambar portfolio
- client_name (optional): Nama client
- location (optional): Lokasi proyek
- completion_date (optional): Tanggal penyelesaian
- project_value (optional): Nilai proyek
- is_featured (boolean): Portfolio unggulan
- is_active (boolean): Status aktif
- ordering (integer): Urutan tampil
```

### 2.2 Homepage Integration

**Dynamic Portfolio Display:**
- Homepage menampilkan portfolio langsung dari database
- Prioritas: Featured portfolio → Latest portfolio
- Limit: 3 portfolio di homepage
- Auto-fallback jika tidak ada featured portfolio

**Portfolio Card Information:**
- Gambar portfolio dengan placeholder jika kosong
- Judul dan deskripsi (80 karakter)
- Category badge dengan styling
- Project value dalam format currency
- Lokasi dengan icon map marker
- Completion date dalam format Month Year
- Client name di pojok kanan
- Link ke detail portfolio

### 2.3 Portfolio Gallery Page

**Lokasi**: `/portfolio`

**Fitur:**
- Menampilkan semua portfolio aktif
- Filter berdasarkan kategori
- Responsive grid layout
- Link ke detail individual portfolio

### 2.4 Portfolio Detail Page

**Lokasi**: `/portfolio/{portfolio}`

**Fitur:**
- Detail lengkap portfolio
- Related portfolios (kategori sama)
- Responsive design
- SEO optimized

## 3. Database Schema

### 3.1 Portfolio Model

```php
class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'category',
        'image_path',
        'client_name',
        'location',
        'completion_date',
        'project_value',
        'is_featured',
        'is_active',
        'ordering'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'project_value' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
```

### 3.2 Model Scopes

```php
// Scopes untuk query optimization
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeFeatured($query)
{
    return $query->where('is_featured', true);
}

public function scopeByCategory($query, $category)
{
    return $query->where('category', $category);
}

public function scopeOrdered($query)
{
    return $query->orderBy('ordering', 'asc')
                 ->orderBy('created_at', 'desc');
}
```

## 4. Controller Logic

### 4.1 HomeController Integration

```php
// Get featured portfolios for homepage
$featuredPortfolios = Portfolio::active()
                        ->featured()
                        ->ordered()
                        ->limit(3)
                        ->get();

// Fallback to latest if no featured
if ($featuredPortfolios->isEmpty()) {
    $featuredPortfolios = Portfolio::active()
                            ->ordered()
                            ->limit(3)
                            ->get();
}
```

### 4.2 Admin Portfolio Controller

**Key Methods:**
- `index()`: List portfolios with pagination
- `create()`: Show create form
- `store()`: Save new portfolio
- `show()`: Display portfolio detail
- `edit()`: Show edit form
- `update()`: Update portfolio
- `destroy()`: Delete portfolio

## 5. Frontend Implementation

### 5.1 Homepage Portfolio Section

**Features:**
- Responsive grid (1 col mobile, 2 col tablet, 3 col desktop)
- Hover effects dengan transform dan shadow
- Category badges dengan color coding
- Currency formatting untuk project value
- Date formatting untuk completion date
- Fallback static portfolios jika database kosong

### 5.2 Admin Interface

**Features:**
- DataTables untuk listing dengan search/filter
- Form validation client-side dan server-side
- Image upload dengan preview
- Status toggles untuk featured/active
- Bulk operations untuk multiple portfolios

## 6. Routes

### 6.1 Public Routes

```php
Route::get('/portfolio', [HomeController::class, 'portfolio'])
    ->name('portfolio');
    
Route::get('/portfolio/{portfolio}', [HomeController::class, 'portfolioDetail'])
    ->name('portfolio.detail');
```

### 6.2 Admin Routes

```php
Route::resource('portfolios', AdminPortfolioController::class);
```

**Generated Routes:**
- `GET /admin/portfolios` → index
- `GET /admin/portfolios/create` → create
- `POST /admin/portfolios` → store
- `GET /admin/portfolios/{portfolio}` → show
- `GET /admin/portfolios/{portfolio}/edit` → edit
- `PUT/PATCH /admin/portfolios/{portfolio}` → update
- `DELETE /admin/portfolios/{portfolio}` → destroy

## 7. Security & Validation

### 7.1 Validation Rules

```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'category' => 'required|string|max:100',
    'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'client_name' => 'nullable|string|max:255',
    'location' => 'nullable|string|max:255',
    'completion_date' => 'nullable|date',
    'project_value' => 'nullable|numeric|min:0',
    'is_featured' => 'boolean',
    'is_active' => 'boolean',
    'ordering' => 'nullable|integer|min:0'
]);
```

### 7.2 Authorization

- Admin middleware untuk semua admin routes
- Public access untuk portfolio display
- Image upload security dengan validation

## 8. Performance Optimization

### 8.1 Database Optimization

- Indexing pada kolom yang sering di-query
- Eager loading untuk relationships
- Pagination untuk admin listing
- Caching untuk homepage portfolio

### 8.2 Image Optimization

- Image compression saat upload
- Responsive image sizing
- Lazy loading untuk gallery
- WebP format support

## 9. Future Enhancements

### 9.1 Planned Features

- Portfolio categories management
- Portfolio tags system
- Portfolio search functionality
- Portfolio analytics dan views tracking
- Portfolio SEO optimization
- Portfolio social sharing

### 9.2 Technical Improvements

- Image variants (thumbnail, medium, large)
- CDN integration untuk images
- Portfolio API endpoints
- Portfolio export functionality
- Portfolio backup system

---

*Portfolio Management System ini dirancang untuk memberikan fleksibilitas maksimal dalam mengelola dan menampilkan portfolio proyek dengan interface yang user-friendly dan performance yang optimal.*
