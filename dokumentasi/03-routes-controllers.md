# Routes dan Controllers - Aplikasi Ardfya v2

## 1. Gambaran Umum Routing

Aplikasi Ardfya v2 menggunakan sistem routing Laravel yang terorganisir dengan baik, dibagi menjadi beberapa kelompok berdasarkan fungsi dan level akses:

- **Public Routes**: Dapat diakses tanpa autentikasi
- **Authenticated Routes**: Memerlukan login user
- **Admin Routes**: Memerlukan login dan role admin
- **API Routes**: Endpoint untuk komunikasi AJAX/API (saat ini dinonaktifkan)

## 1.1 Perubahan Setelah Cleanup (v2.1)

### Fitur yang Dihapus:
- ❌ Test controllers (`TestAdminController`, `AdminSimpleController`)
- ❌ Development routes (`/admin-test`, `/admin-simple`, `/test-admin`)
- ❌ Unused API endpoints
- ❌ Duplicate inquiry routes
- ❌ AdminAuthController (tidak digunakan)

### Optimisasi:
- ✅ Routes lebih bersih dan terorganisir
- ✅ Tidak ada endpoint testing yang exposed
- ✅ Performance lebih baik

## 2. Struktur Routes

### 2.1 Public Routes
Routes yang dapat diakses oleh semua pengunjung tanpa autentikasi.

| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/` | HomeController@index | home | Halaman utama |
| GET | `/about` | HomeController@about | about | Halaman tentang |
| GET | `/portfolio` | HomeController@portfolio | portfolio | Halaman portfolio |
| GET | `/contact` | HomeController@contact | contact | Halaman kontak |
| POST | `/contact/send` | ContactController@send | contact.send | Kirim pesan kontak |

#### Service Routes (Public)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/services` | ServiceController@index | services.index | Daftar layanan |
| GET | `/services/{service}` | ServiceController@show | services.show | Detail layanan |
| GET | `/services/{service}/inquire` | ServiceController@inquire | services.inquire | Form inquiry layanan |

#### Inquiry Routes (Public)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/inquiries/create/{serviceId?}` | InquiryController@create | inquiries.create | Form inquiry baru |
| POST | `/inquiries` | InquiryController@store | inquiries.store | Simpan inquiry |
| GET | `/services/{slug}/inquire` | InquiryController@inquire | services.inquire | Form inquiry per layanan |
| GET | `/layanan/permintaan` | InquiryController@create | inquiry.create | Form permintaan (ID) |
| POST | `/layanan/permintaan` | InquiryController@store | inquiry.store | Simpan permintaan (ID) |

### 2.2 Authentication Routes
Routes untuk sistem autentikasi Laravel (Auth::routes()).

| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/login` | Auth\LoginController@showLoginForm | login | Form login |
| POST | `/login` | Auth\LoginController@login | - | Proses login |
| POST | `/logout` | Auth\LoginController@logout | logout | Logout |
| GET | `/register` | Auth\RegisterController@showRegistrationForm | register | Form registrasi |
| POST | `/register` | Auth\RegisterController@register | - | Proses registrasi |
| GET | `/password/reset` | Auth\ForgotPasswordController@showLinkRequestForm | password.request | Form reset password |
| POST | `/password/email` | Auth\ForgotPasswordController@sendResetLinkEmail | password.email | Kirim link reset |

### 2.3 Authenticated User Routes
Routes yang memerlukan autentikasi user (middleware: auth).

#### Profile Management
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/profile` | ProfileController@edit | profile.edit | Edit profil |
| PATCH | `/profile` | ProfileController@update | profile.update | Update profil |
| PUT | `/profile/password` | ProfileController@updatePassword | profile.password.update | Update password |
| DELETE | `/profile` | ProfileController@destroy | profile.destroy | Hapus akun |

#### Customer Chat/Messages
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/messages` | MessageController@customerChat | messages.customer | Chat customer |
| GET | `/messages/get` | MessageController@getMessages | messages.get | Ambil pesan |
| POST | `/messages/send` | MessageController@sendMessage | messages.send | Kirim pesan |
| POST | `/messages/read` | MessageController@markAsRead | messages.read | Tandai dibaca |

#### Real-time Chat
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/chat/messages` | ChatController@getMessages | chat.messages | Ambil pesan chat |
| POST | `/chat/send` | ChatController@store | chat.send | Kirim pesan chat |
| POST | `/chat/read` | ChatController@markAsRead | chat.read | Tandai chat dibaca |

### 2.4 Admin Authentication Routes
Routes khusus untuk autentikasi admin (prefix: admin).

| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/login` | AdminController@showLoginForm | admin.login | Form login admin |
| POST | `/admin/login` | AdminController@login | - | Proses login admin |
| POST | `/admin/logout` | AdminController@logout | admin.logout | Logout admin |

### 2.5 Admin Panel Routes
Routes untuk panel admin (middleware: auth, admin | prefix: admin).

#### Dashboard
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/` | AdminDashboardController@index | admin.dashboard | Dashboard admin |

#### Messages & Chat Management
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/messages` | AdminMessageController@index | admin.messages.index | Daftar pesan |
| GET | `/admin/messages/stats` | AdminMessageController@getStats | admin.messages.stats | Statistik pesan |
| GET | `/admin/chat/customers` | ChatController@getCustomers | admin.chat.customers | Daftar customer chat |
| GET | `/admin/chat/messages` | ChatController@getMessages | admin.chat.messages | Pesan chat |
| GET | `/admin/chat/all` | ChatController@getAllChats | admin.chat.all | Semua chat |
| POST | `/admin/chat/reply/{customerId}` | ChatController@adminReply | admin.chat.reply | Balas chat |
| POST | `/admin/chat/read` | ChatController@markAsRead | admin.chat.read | Tandai dibaca |

#### Admin API Routes
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/api/inquiries` | AdminMessageController@getInquiries | admin.api.inquiries | API data inquiry |
| GET | `/admin/api/projects` | AdminMessageController@getProjects | admin.api.projects | API data proyek |

#### Inquiry Management (Resource Routes)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/inquiries` | AdminInquiryController@index | admin.inquiries.index | Daftar inquiry |
| GET | `/admin/inquiries/create` | AdminInquiryController@create | admin.inquiries.create | Form inquiry baru |
| POST | `/admin/inquiries` | AdminInquiryController@store | admin.inquiries.store | Simpan inquiry |
| GET | `/admin/inquiries/{inquiry}` | AdminInquiryController@show | admin.inquiries.show | Detail inquiry |
| GET | `/admin/inquiries/{inquiry}/edit` | AdminInquiryController@edit | admin.inquiries.edit | Edit inquiry |
| PUT/PATCH | `/admin/inquiries/{inquiry}` | AdminInquiryController@update | admin.inquiries.update | Update inquiry |
| DELETE | `/admin/inquiries/{inquiry}` | AdminInquiryController@destroy | admin.inquiries.destroy | Hapus inquiry |
| POST | `/admin/inquiries/{inquiry}/update-status` | AdminInquiryController@updateStatus | admin.inquiries.updateStatus | Update status |
| POST | `/admin/inquiries/fix` | AdminInquiryController@fixOrphanedInquiries | admin.inquiries.fix | Perbaiki inquiry |

#### Project Management (Resource Routes)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/projects` | AdminProjectController@index | admin.projects.index | Daftar proyek |
| GET | `/admin/projects/create` | AdminProjectController@create | admin.projects.create | Form proyek baru |
| POST | `/admin/projects` | AdminProjectController@store | admin.projects.store | Simpan proyek |
| GET | `/admin/projects/{project}` | AdminProjectController@show | admin.projects.show | Detail proyek |
| GET | `/admin/projects/{project}/edit` | AdminProjectController@edit | admin.projects.edit | Edit proyek |
| PUT/PATCH | `/admin/projects/{project}` | AdminProjectController@update | admin.projects.update | Update proyek |
| DELETE | `/admin/projects/{project}` | AdminProjectController@destroy | admin.projects.destroy | Hapus proyek |

#### Customer Management (Resource Routes)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/customers` | AdminCustomerController@index | admin.customers.index | Daftar customer |
| GET | `/admin/customers/create` | AdminCustomerController@create | admin.customers.create | Form customer baru |
| POST | `/admin/customers` | AdminCustomerController@store | admin.customers.store | Simpan customer |
| GET | `/admin/customers/{customer}` | AdminCustomerController@show | admin.customers.show | Detail customer |
| GET | `/admin/customers/{customer}/edit` | AdminCustomerController@edit | admin.customers.edit | Edit customer |
| PUT/PATCH | `/admin/customers/{customer}` | AdminCustomerController@update | admin.customers.update | Update customer |
| DELETE | `/admin/customers/{customer}` | AdminCustomerController@destroy | admin.customers.destroy | Hapus customer |
| GET | `/admin/customers/json` | AdminCustomerController@getCustomersJson | admin.customers.json | Data customer JSON |

#### Contract Management (Resource Routes)
| Method | URI | Controller@Method | Route Name | Description |
|--------|-----|-------------------|------------|-------------|
| GET | `/admin/contracts` | AdminContractController@index | admin.contracts.index | Daftar kontrak |
| GET | `/admin/contracts/create` | AdminContractController@create | admin.contracts.create | Form kontrak baru |
| POST | `/admin/contracts` | AdminContractController@store | admin.contracts.store | Simpan kontrak |
| GET | `/admin/contracts/{contract}` | AdminContractController@show | admin.contracts.show | Detail kontrak |
| GET | `/admin/contracts/{contract}/edit` | AdminContractController@edit | admin.contracts.edit | Edit kontrak |
| PUT/PATCH | `/admin/contracts/{contract}` | AdminContractController@update | admin.contracts.update | Update kontrak |
| DELETE | `/admin/contracts/{contract}` | AdminContractController@destroy | admin.contracts.destroy | Hapus kontrak |
| GET | `/admin/contracts/{contract}/download` | AdminContractController@download | admin.contracts.download | Download kontrak |
| GET | `/admin/contracts/{contract}/print` | AdminContractController@print | admin.contracts.print | Print kontrak |

## 3. Controllers Detail

### 3.1 HomeController
**Namespace**: `App\Http\Controllers\HomeController`
**Middleware**: Tidak ada (public)

#### Methods:
- `index()`: Menampilkan halaman utama dengan featured services dan projects
- `about()`: Menampilkan halaman tentang
- `portfolio()`: Menampilkan portfolio proyek yang sudah selesai
- `contact()`: Menampilkan halaman kontak

#### Key Features:
- Mengambil 6 layanan aktif untuk ditampilkan di homepage
- Mengambil 3 proyek unggulan untuk showcase
- Menampilkan semua proyek dengan status 'completed' di portfolio

### 3.2 AdminDashboardController
**Namespace**: `App\Http\Controllers\Admin\DashboardController`
**Middleware**: AdminMiddleware

#### Methods:
- `index()`: Menampilkan dashboard admin dengan statistik lengkap
- `fixOrphanedInquiries()`: Memperbaiki inquiry yang tidak memiliki user_id

#### Key Features:
- Menghitung total customer, inquiry, proyek, dan kontrak
- Menampilkan inquiry terbaru dengan relasi service dan user
- Mengelompokkan inquiry berdasarkan status
- Menampilkan proyek yang sedang berjalan
- Mengelompokkan proyek berdasarkan status
- Mengelompokkan kontrak berdasarkan status pembayaran
- Menampilkan pesan terbaru
- Deteksi dan perbaikan orphaned inquiries

### 3.3 ServiceController
**Namespace**: `App\Http\Controllers\ServiceController`
**Middleware**: Tidak ada (public)

#### Methods:
- `index()`: Menampilkan daftar semua layanan aktif
- `show($service)`: Menampilkan detail layanan
- `inquire($service)`: Menampilkan form inquiry untuk layanan tertentu

### 3.4 InquiryController
**Namespace**: `App\Http\Controllers\InquiryController`
**Middleware**: Tidak ada (public untuk create/store)

#### Methods:
- `create($serviceId = null)`: Menampilkan form inquiry baru
- `store(Request $request)`: Menyimpan inquiry baru
- `inquire($slug)`: Form inquiry berdasarkan slug layanan

#### Validation Rules:
```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'service_id' => 'required|exists:services,id',
    'property_type' => 'nullable|string|max:255',
    'address' => 'required|string',
    'area_size' => 'nullable|integer|min:1',
    'budget' => 'nullable|numeric|min:0',
    'description' => 'required|string',
    'start_date' => 'nullable|date|after:today',
    'schedule_flexibility' => 'nullable|string|max:255',
    'current_condition' => 'nullable|string'
]);
```

### 3.5 ChatController
**Namespace**: `App\Http\Controllers\ChatController`
**Middleware**: auth (untuk customer), auth+admin (untuk admin)

#### Methods:
- `getMessages(Request $request)`: Mengambil pesan chat
- `store(Request $request)`: Menyimpan pesan chat baru
- `markAsRead(Request $request)`: Menandai pesan sebagai sudah dibaca
- `getCustomers()`: Mengambil daftar customer untuk admin
- `getAllChats()`: Mengambil semua chat untuk admin
- `adminReply($customerId, Request $request)`: Admin membalas chat customer

## 4. Middleware yang Digunakan

### 4.1 AdminMiddleware
**Path**: `App\Http\Middleware\AdminMiddleware`
**Fungsi**: Memastikan user yang mengakses adalah admin

```php
public function handle($request, Closure $next)
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect()->route('login')
            ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    
    return $next($request);
}
```

### 4.2 Built-in Middleware
- `auth`: Memastikan user sudah login
- `guest`: Memastikan user belum login
- `throttle`: Rate limiting untuk API
- `verified`: Email verification

## 5. Route Model Binding

Aplikasi menggunakan implicit route model binding untuk:
- `{service}`: Binding ke model Service
- `{inquiry}`: Binding ke model Inquiry  
- `{project}`: Binding ke model Project
- `{contract}`: Binding ke model Contract
- `{customer}`: Binding ke model User

## 6. API Endpoints

### 6.1 Admin API Routes (Internal)
- `GET /admin/api/inquiries`: Mengambil data inquiry dalam format JSON
- `GET /admin/api/projects`: Mengambil data proyek dalam format JSON

### 6.2 Chat API Routes (AJAX)
- `GET /chat/messages`: Mengambil pesan chat
- `POST /chat/send`: Mengirim pesan chat
- `POST /chat/read`: Menandai pesan dibaca

### 6.3 Customer API Routes (Internal)
- `GET /admin/customers/json`: Mengambil data customer dalam format JSON

### 6.4 Public API Routes (Dinonaktifkan)
**Status**: Saat ini dinonaktifkan untuk optimisasi performa
- ~~`GET /api/services`: Mengambil daftar layanan~~
- ~~`GET /api/inquiries`: Mengambil inquiry user~~
- ~~`GET /api/user`: Mengambil data user (Sanctum)~~

**Catatan**: API routes dapat diaktifkan kembali jika diperlukan untuk integrasi frontend framework atau mobile app.

## 7. Error Handling

### 7.1 Controller Error Handling
Controllers menggunakan try-catch blocks untuk menangani error:

```php
try {
    // Business logic
    return view('admin.dashboard', compact('data'));
} catch (Exception $e) {
    Log::error('Error message', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    return view('admin.dashboard', ['error' => $e->getMessage()]);
}
```

### 7.2 Validation Error Handling
Menggunakan Laravel Form Request Validation dengan automatic error handling dan redirect back dengan error messages.

---

*Sistem routing ini dirancang untuk memberikan struktur yang jelas, keamanan yang baik, dan kemudahan maintenance dengan pemisahan yang tepat antara public, authenticated, dan admin routes.*
