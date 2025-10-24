# Arsitektur dan Tech Stack - Aplikasi Ardfya v2

## 1. Arsitektur Aplikasi

### 1.1 Arsitektur Umum
Aplikasi Ardfya v2 menggunakan arsitektur **MVC (Model-View-Controller)** yang merupakan pola arsitektur standar Laravel dengan beberapa layer tambahan:

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                       │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Blade Views   │  │  TailwindCSS    │  │  Alpine.js  │ │
│  │   Bootstrap 5   │  │  JavaScript     │  │   Assets    │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                   APPLICATION LAYER                         │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Controllers   │  │   Middleware    │  │   Routes    │ │
│  │   Requests      │  │   Policies      │  │   Services  │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                    BUSINESS LAYER                           │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Models        │  │   Eloquent      │  │   Events    │ │
│  │   Observers     │  │   Relationships │  │   Jobs      │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                     DATA LAYER                              │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Database      │  │   Migrations    │  │   Seeders   │ │
│  │   SQLite/MySQL  │  │   Factories     │  │   Storage   │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### 1.2 Pola Arsitektur yang Digunakan

#### Repository Pattern (Partial)
- Menggunakan Eloquent ORM sebagai abstraksi data access
- Model sebagai repository untuk business logic

#### Service Layer Pattern
- Controller yang lean dengan logic di Service classes
- Separation of concerns yang jelas

#### Observer Pattern
- Event-driven architecture untuk notifikasi
- Model observers untuk audit trail

## 2. Tech Stack Detail

### 2.1 Backend Technologies

#### Core Framework
- **Laravel 12.x**: Framework PHP modern dengan fitur lengkap
- **PHP 8.2+**: Bahasa pemrograman dengan type declarations dan performance improvements

#### Database & ORM
- **SQLite**: Database untuk development (ringan dan portable)
- **MySQL/PostgreSQL**: Database untuk production
- **Eloquent ORM**: Object-Relational Mapping untuk database operations
- **Database Migrations**: Version control untuk database schema

#### Authentication & Security
- **Laravel Sanctum**: API authentication
- **Laravel Auth**: Web authentication system
- **CSRF Protection**: Built-in CSRF protection
- **Custom Middleware**: AdminMiddleware untuk role-based access

#### Additional Packages
```json
{
  "barryvdh/laravel-dompdf": "^3.1",     // PDF generation
  "laravel/sanctum": "^4.1",            // API authentication
  "laravel/tinker": "^2.10.1",          // REPL for Laravel
  "laravel/ui": "^4.6",                 // UI scaffolding
  "pusher/pusher-php-server": "^7.2"    // Real-time messaging
}
```

### 2.2 Frontend Technologies

#### Core Frontend Stack
- **Blade Templates**: Server-side templating engine
- **TailwindCSS 3.3.5**: Utility-first CSS framework
- **Bootstrap 5.3.6**: Component-based CSS framework
- **Alpine.js 3.14.9**: Lightweight JavaScript framework

#### Build Tools & Asset Management
- **Vite 6.2.4**: Modern build tool dan dev server
- **Laravel Vite Plugin**: Integration antara Laravel dan Vite
- **PostCSS**: CSS processing dengan autoprefixer
- **Sass**: CSS preprocessor

#### JavaScript Libraries
```json
{
  "axios": "^1.8.2",           // HTTP client
  "laravel-echo": "^2.1.4",   // Real-time event broadcasting
  "pusher-js": "^8.4.0",      // WebSocket client
  "@popperjs/core": "^2.11.6" // Tooltip dan popover positioning
}
```

### 2.3 Development Tools

#### Testing Framework
- **Pest PHP 3.8**: Modern testing framework
- **PHPUnit**: Unit testing foundation
- **Laravel Testing**: Feature dan unit testing tools

#### Code Quality
- **Laravel Pint**: Code style fixer
- **Laravel Pail**: Log viewer
- **Collision**: Error reporting

#### Development Utilities
- **Laravel Sail**: Docker development environment
- **Concurrently**: Run multiple commands simultaneously
- **Faker**: Generate fake data untuk testing

## 3. Konfigurasi Sistem

### 3.1 Database Configuration
```php
// config/database.php
'default' => env('DB_CONNECTION', 'sqlite'),

'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
        'foreign_key_constraints' => true,
    ],
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]
]
```

### 3.2 Application Configuration
```php
// config/app.php
'name' => env('APP_NAME', 'Ardfya'),
'env' => env('APP_ENV', 'production'),
'debug' => (bool) env('APP_DEBUG', false),
'url' => env('APP_URL', 'http://localhost'),
'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
'locale' => env('APP_LOCALE', 'id'),
```

### 3.3 Build Configuration
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
});
```

## 4. Struktur Direktori

### 4.1 Struktur Backend
```
app/
├── Console/
│   ├── Commands/           # Custom Artisan commands
│   └── Kernel.php         # Command scheduling
├── Http/
│   ├── Controllers/       # Request handlers
│   │   ├── Admin/        # Admin-specific controllers
│   │   └── Auth/         # Authentication controllers
│   ├── Middleware/       # HTTP middleware
│   └── Requests/         # Form request validation
├── Models/               # Eloquent models
├── Providers/           # Service providers
└── Services/            # Business logic services
```

### 4.2 Struktur Frontend
```
resources/
├── css/
│   └── app.css          # Main CSS file
├── js/
│   └── app.js           # Main JavaScript file
├── sass/                # Sass stylesheets
└── views/               # Blade templates
    ├── admin/           # Admin interface views
    ├── auth/            # Authentication views
    ├── components/      # Reusable components
    ├── home/            # Public pages
    └── layouts/         # Layout templates
```

## 5. Performance & Scalability

### 5.1 Caching Strategy
- **Route Caching**: Pre-compiled routes untuk production
- **Config Caching**: Cached configuration files
- **View Caching**: Compiled Blade templates
- **Query Optimization**: Eager loading untuk menghindari N+1 queries

### 5.2 Asset Optimization
- **Vite Build**: Optimized dan minified assets
- **CSS Purging**: Unused CSS removal dengan TailwindCSS
- **Image Optimization**: Lazy loading dan responsive images
- **CDN Ready**: Asset URLs dapat dikonfigurasi untuk CDN

### 5.3 Database Optimization
- **Indexing**: Proper database indexes pada foreign keys
- **Query Optimization**: Efficient Eloquent queries
- **Connection Pooling**: Database connection management
- **Migration Strategy**: Incremental database changes

---

*Arsitektur ini dirancang untuk mendukung skalabilitas, maintainability, dan performance yang optimal untuk aplikasi enterprise-level.*
