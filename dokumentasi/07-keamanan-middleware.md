# Keamanan dan Middleware - Aplikasi Ardfya v2

## 1. Gambaran Umum Keamanan

Aplikasi Ardfya v2 mengimplementasikan sistem keamanan berlapis (defense in depth) dengan berbagai mekanisme perlindungan:

- **Authentication**: Verifikasi identitas pengguna
- **Authorization**: Kontrol akses berdasarkan role
- **Input Validation**: Validasi dan sanitasi input
- **CSRF Protection**: Perlindungan dari Cross-Site Request Forgery
- **SQL Injection Prevention**: Penggunaan Eloquent ORM dan prepared statements
- **XSS Protection**: Perlindungan dari Cross-Site Scripting
- **Session Security**: Manajemen session yang aman
- **Password Security**: Hashing dan policy yang kuat

## 2. Sistem Authentication

### 2.1 Multi-Guard Authentication

Aplikasi menggunakan sistem multi-guard untuk memisahkan autentikasi user dan admin:

```php
// config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

### 2.2 User Authentication

**Features:**
- Email-based login
- Password hashing dengan bcrypt
- Remember me functionality
- Email verification (optional)
- Password reset via email

**Implementation:**
```php
// Login process
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials',
    ]);
}
```

### 2.3 Admin Authentication

**Separate Admin System:**
```php
// AdminAuthController
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials',
    ]);
}
```

**Security Features:**
- Separate authentication guard
- Session regeneration after login
- Secure logout with session invalidation
- Admin-specific password policies

## 3. Authorization System

### 3.1 Role-Based Access Control (RBAC)

**User Roles:**
- **Customer**: Regular users yang dapat submit inquiry dan track projects
- **Admin**: Full access ke admin panel dan management features

**Role Implementation:**
```php
// User Model
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

// Usage in controllers
if (!Auth::user()->isAdmin()) {
    return redirect('/')->with('error', 'Unauthorized access');
}
```

### 3.2 Route Protection

**Public Routes**: Accessible tanpa authentication
```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/inquiries', [InquiryController::class, 'store']);
```

**Authenticated Routes**: Require login
```php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::get('/messages', [MessageController::class, 'customerChat']);
});
```

**Admin Routes**: Require admin role
```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::resource('projects', AdminProjectController::class);
});
```

## 4. Middleware System

### 4.1 AdminMiddleware

**Purpose**: Memastikan hanya admin yang dapat mengakses admin routes

```php
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Check if user is admin
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }
        
        // Check if admin guard is active
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        
        // Redirect to home if not admin
        return redirect('/')->with('error', 'You do not have admin access');
    }
}
```

### 4.2 Built-in Laravel Middleware

**Global Middleware:**
```php
// app/Http/Kernel.php
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
    \Illuminate\Http\Middleware\HandleCors::class,
    \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
];
```

**Route Middleware:**
```php
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

### 4.3 CSRF Protection

**Implementation:**
```php
// Automatic CSRF protection for all POST, PUT, PATCH, DELETE requests
// In forms:
<form method="POST" action="{{ route('inquiries.store') }}">
    @csrf
    <!-- form fields -->
</form>

// In AJAX requests:
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

**CSRF Token Management:**
```html
<!-- In layout head -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- In JavaScript -->
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

## 5. Input Validation dan Sanitization

### 5.1 Form Request Validation

**Inquiry Validation:**
```php
$validated = $request->validate([
    'service_id' => 'required|exists:services,id',
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'required|string',
    'address' => 'required|string',
    'property_type' => 'required|string',
    'area_size' => 'required|numeric|min:1',
    'budget' => 'required|numeric|min:0|max:9999999999.99',
    'description' => 'required|string',
    'start_date' => 'nullable|date|after:today',
]);
```

**Project Validation:**
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'user_id' => 'required|exists:users,id',
    'service_id' => 'required|exists:services,id',
    'description' => 'required|string',
    'start_date' => 'required|date',
    'expected_end_date' => 'nullable|date|after_or_equal:start_date',
    'budget' => 'required|numeric|min:0',
    'progress_percentage' => 'required|integer|min:0|max:100',
]);
```

### 5.2 Data Sanitization

**Automatic Sanitization:**
```php
// TrimStrings middleware - removes whitespace
// ConvertEmptyStringsToNull middleware - converts empty strings to null

// Manual sanitization
$cleanInput = strip_tags($request->input('description'));
$safeHtml = htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
```

### 5.3 File Upload Security

**File Validation:**
```php
$request->validate([
    'contract_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
    'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
    'project_images.*' => 'image|mimes:jpg,jpeg,png|max:2048', // 2MB max per image
]);
```

**Secure File Storage:**
```php
// Store files outside public directory
$path = $request->file('contract_file')->store('contracts', 'private');

// Generate secure filenames
$filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
```

## 6. Database Security

### 6.1 SQL Injection Prevention

**Eloquent ORM Protection:**
```php
// Safe - uses parameter binding
$users = User::where('email', $email)->get();
$projects = Project::where('status', 'active')->where('user_id', $userId)->get();

// Safe - query builder with bindings
$results = DB::select('SELECT * FROM projects WHERE user_id = ?', [$userId]);
```

### 6.2 Mass Assignment Protection

**Fillable Attributes:**
```php
class User extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'role'
    ];
    
    protected $hidden = [
        'password', 'remember_token'
    ];
}
```

### 6.3 Database Transactions

**Atomic Operations:**
```php
try {
    DB::beginTransaction();
    
    $user = User::create($userData);
    $inquiry = Inquiry::create($inquiryData);
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

## 7. Session Security

### 7.1 Session Configuration

```php
// config/session.php
'lifetime' => 120, // 2 hours
'expire_on_close' => false,
'encrypt' => false,
'files' => storage_path('framework/sessions'),
'connection' => null,
'table' => 'sessions',
'store' => null,
'lottery' => [2, 100],
'cookie' => env('SESSION_COOKIE', 'laravel_session'),
'path' => '/',
'domain' => env('SESSION_DOMAIN', null),
'secure' => env('SESSION_SECURE_COOKIE', false),
'http_only' => true,
'same_site' => 'lax',
```

### 7.2 Session Security Measures

**Session Regeneration:**
```php
// After login
$request->session()->regenerate();

// After logout
$request->session()->invalidate();
$request->session()->regenerateToken();
```

**Session Fixation Prevention:**
```php
// Automatic session regeneration on authentication
Auth::attempt($credentials);
// Laravel automatically regenerates session ID
```

## 8. Password Security

### 8.1 Password Hashing

```php
// Automatic hashing in User model
protected function casts(): array
{
    return [
        'password' => 'hashed',
    ];
}

// Manual hashing
$hashedPassword = Hash::make($password);

// Password verification
if (Hash::check($password, $hashedPassword)) {
    // Password is correct
}
```

### 8.2 Password Policies

**Validation Rules:**
```php
'password' => [
    'required',
    'string',
    'min:8',
    'confirmed',
    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
],
```

## 9. API Security

### 9.1 Rate Limiting

```php
// API rate limiting
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/api/inquiries', [InquiryController::class, 'store']);
});

// Custom rate limiting
Route::middleware('throttle:api')->group(function () {
    // API routes
});
```

### 9.2 API Authentication

```php
// Sanctum for API authentication
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
```

## 10. Error Handling dan Logging

### 10.1 Secure Error Handling

```php
try {
    // Business logic
} catch (\Exception $e) {
    Log::error('Operation failed', [
        'error' => $e->getMessage(),
        'user_id' => Auth::id(),
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);
    
    // Don't expose sensitive information
    return back()->with('error', 'An error occurred. Please try again.');
}
```

### 10.2 Security Logging

```php
// Log security events
Log::channel('security')->info('Admin login attempt', [
    'email' => $request->email,
    'ip' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'success' => $success,
]);
```

## 11. Environment Security

### 11.1 Environment Variables

```env
# Secure configuration
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:generated-key

# Database credentials
DB_PASSWORD=strong-password

# Session security
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

### 11.2 Production Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] Strong APP_KEY generated
- [ ] HTTPS enabled
- [ ] Secure session cookies
- [ ] Regular security updates
- [ ] Database credentials secured
- [ ] File permissions properly set
- [ ] Error logging configured
- [ ] Backup strategy implemented

---

*Sistem keamanan ini dirancang untuk memberikan perlindungan berlapis yang komprehensif terhadap berbagai ancaman keamanan web modern, memastikan data dan sistem tetap aman.*
