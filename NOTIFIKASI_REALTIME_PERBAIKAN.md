# Perbaikan Sistem Notifikasi Real-time

## Masalah yang Ditemukan

1. **BROADCAST_CONNECTION=log** - Notifikasi tidak real-time, hanya log
2. **Tidak ada konfigurasi Pusher** yang proper di .env
3. **Notifikasi badge hanya update saat page refresh** - tidak ada JavaScript untuk update realtime
4. **Tidak ada listener Echo** untuk notifikasi umum di dashboard

## Perbaikan yang Dilakukan

### 1. Konfigurasi Environment (.env)
- Mengubah `BROADCAST_CONNECTION=log` menjadi `BROADCAST_CONNECTION=pusher`
- Menambahkan konfigurasi Pusher lengkap:
  ```env
  PUSHER_APP_ID=local-app-id
  PUSHER_APP_KEY=local-app-key
  PUSHER_APP_SECRET=local-app-secret
  PUSHER_HOST=127.0.0.1
  PUSHER_PORT=6001
  PUSHER_SCHEME=http
  PUSHER_APP_CLUSTER=mt1
  
  VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
  VITE_PUSHER_HOST="${PUSHER_HOST}"
  VITE_PUSHER_PORT="${PUSHER_PORT}"
  VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
  VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
  ```

### 2. Event Broadcasting
Membuat event baru untuk broadcast real-time:

#### a. InquiryStatusUpdated Event
- Broadcast ketika status inquiry diubah
- Channel: `user.{userId}` dan `admin.notifications`

#### b. NewInquiryReceived Event  
- Broadcast ketika inquiry baru dibuat
- Channel: `admin.notifications`

#### c. ProjectUpdated Event
- Broadcast ketika project diupdate (status, progress, dll)
- Channel: `user.{userId}` dan `admin.notifications`

### 3. Channel Authorization (routes/channels.php)
Menambahkan authorization untuk channel baru:
```php
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('admin.notifications', function ($user) {
    return $user->role === 'admin';
});
```

### 4. API Endpoint untuk Notification Count
Membuat endpoint `/api/notifications/count` untuk mendapatkan:
- Jumlah notifikasi yang belum dibaca
- Jumlah pesan yang belum dibaca
- Total count untuk update badge real-time

### 5. JavaScript Real-time Updates

#### Admin Dashboard (layouts/admin.blade.php)
- Listener untuk `admin.chat` channel (pesan baru)
- Listener untuk `admin.notifications` channel (inquiry baru)
- Function `updateNotificationBadges()` untuk update badge secara real-time
- Fallback polling setiap 30 detik

#### Customer Dashboard (layouts/customer.blade.php)
- Listener untuk `chat.{userId}` channel (pesan dari admin)
- Listener untuk `user.{userId}` channel (inquiry status, project updates)
- Function `updateCustomerNotificationBadges()` untuk update badge
- Fallback polling setiap 30 detik

### 6. UI Components Update

#### Notification Badge Component
- Menambahkan class `notification-badge` untuk targeting JavaScript
- Badge tersembunyi ketika count = 0, muncul ketika ada notifikasi

#### Dashboard Elements
- Menambahkan class `message-badge` dan `message-count` untuk update real-time
- Chat notification card di customer dashboard dengan badge count

### 7. Controller Updates

#### InquiryController
- Broadcast `NewInquiryReceived` event saat inquiry baru dibuat
- Broadcast `InquiryStatusUpdated` event saat status diubah

#### ProjectController  
- Broadcast `ProjectUpdated` event saat project dibuat/diupdate
- Deteksi jenis update (status_change, progress_update, new_project)

#### MessageController
- Broadcast `NewChatMessage` event saat pesan dikirim
- Support untuk admin ke customer dan sebaliknya

## Cara Menjalankan Real-time Notifications

### 1. Install Laravel WebSockets (Alternatif Pusher)
```bash
composer require pusher/pusher-php-server
```

### 2. Atau gunakan Pusher.com
- Daftar di pusher.com
- Buat app baru
- Update konfigurasi di .env dengan credentials yang benar

### 3. Jalankan Queue Worker
```bash
php artisan queue:work
```

### 4. Test Notifikasi
- Buat inquiry baru → Admin dapat notifikasi real-time
- Update status inquiry → Customer dapat notifikasi real-time  
- Kirim pesan chat → Badge update real-time
- Update project → Customer dapat notifikasi real-time

## Fitur Real-time yang Sekarang Berfungsi

✅ **Admin Dashboard:**
- Badge notifikasi update real-time
- Notifikasi pesan baru dari customer
- Notifikasi inquiry baru
- Counter pesan belum dibaca update otomatis

✅ **Customer Dashboard:**
- Badge notifikasi update real-time
- Notifikasi pesan baru dari admin
- Notifikasi status inquiry berubah
- Notifikasi update project
- Chat notification card dengan counter

✅ **Fallback System:**
- Jika WebSocket gagal, sistem fallback ke polling setiap 30 detik
- Tidak akan error meski Pusher tidak tersedia

## Error yang Diperbaiki

### SQLSTATE[42S22]: Column not found: 1054 Unknown column 'customer_id' in 'where clause'

**Masalah:**
Query menggunakan kolom `customer_id` pada tabel `messages` yang tidak ada. Tabel `messages` menggunakan `user_id`, sedangkan tabel `chats` yang menggunakan `customer_id`.

**Perbaikan:**
1. **API Endpoint (/api/notifications/count):**
   - Untuk admin: Menghitung unread messages + unread chats dari customers
   - Untuk customer: Menghitung unread messages (user_id) + unread chats (customer_id)

2. **Admin Dashboard & Sidebar:**
   - Menggabungkan count dari tabel `messages` dan `chats`
   - Query: `Message::where('is_from_admin', false)` + `Chat::where('is_from_admin', false)`

3. **Customer Dashboard:**
   - Messages: `Message::where('user_id', Auth::id())->where('is_from_admin', true)`
   - Chats: `Chat::where('customer_id', Auth::id())->where('is_from_admin', true)`

**Struktur Tabel:**
- **messages**: `user_id`, `project_id`, `inquiry_id`, `message`, `is_from_admin`, `is_read`
- **chats**: `customer_id`, `admin_id`, `message`, `is_from_admin`, `is_read`

## Perbaikan Auto Mark as Read

### Masalah Sebelumnya:
- ❌ Notifikasi hanya bertambah, tidak pernah kembali ke nol
- ❌ Badge tidak update setelah halaman dibuka
- ❌ User harus manual klik "mark as read"

### Perbaikan yang Ditambahkan:

#### 1. **Customer Chat Auto Mark as Read**
**File:** `resources/views/messages/customer.blade.php`
```javascript
// Auto mark messages from admin as read
const unreadIds = messages
    .filter(msg => !msg.is_read && msg.is_from_admin)
    .map(msg => msg.id);

if (unreadIds.length > 0) {
    markMessagesAsRead(unreadIds);
}
```

#### 2. **Customer Dashboard Auto Mark as Read**
**File:** `resources/views/customer/dashboard.blade.php`
```javascript
// Auto mark notifications as read when dashboard is opened
fetch('/notifications/read-all', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
```

#### 3. **Admin Dashboard Auto Mark as Read**
**File:** `resources/views/admin/dashboard.blade.php`
```javascript
// Auto mark admin notifications as read when dashboard is opened
fetch('/notifications/read-all', {
    method: 'POST',
    // ... same implementation
})
```

#### 4. **Customer Messages Controller Auto Mark as Read**
**File:** `app/Http/Controllers/MessageController.php`
```php
// Auto mark unread messages from admin as read when customer opens messages page
Chat::where('customer_id', $user->id)
    ->where('is_from_admin', true)
    ->where('is_read', false)
    ->update(['is_read' => true]);

Message::where('user_id', $user->id)
    ->where('is_from_admin', true)
    ->where('is_read', false)
    ->update(['is_read' => true]);
```

#### 5. **Admin Messages Controller Auto Mark as Read**
**File:** `app/Http/Controllers/Admin/MessageController.php`
```php
// Auto mark unread messages from customers as read when admin opens messages page
Message::where('is_from_admin', false)
    ->where('is_read', false)
    ->update(['is_read' => true]);

\App\Models\Chat::where('is_from_admin', false)
    ->where('is_read', false)
    ->update(['is_read' => true]);
```

#### 6. **Customer Notifications Page Auto Mark as Read**
**File:** `resources/views/customer/notifications.blade.php`
```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Auto mark all notifications as read when notifications page is opened
    markAllNotificationsAsRead();
});
```

### Hasil Perbaikan:

✅ **Customer:**
- Dashboard dibuka → Semua notifikasi umum di-mark as read
- Chat dibuka → Pesan dari admin di-mark as read
- Halaman notifikasi dibuka → Semua notifikasi di-mark as read
- Badge langsung update ke nol setelah halaman dibuka

✅ **Admin:**
- Dashboard dibuka → Semua notifikasi umum di-mark as read
- Messages dibuka → Pesan dari customer di-mark as read
- Chat dibuka → Pesan dari customer di-mark as read (sudah ada sebelumnya)
- Badge langsung update ke nol setelah halaman dibuka

### Auto Mark as Read Triggers:

| Halaman | Trigger | Target |
|---------|---------|--------|
| Customer Dashboard | Page Load | Semua notifikasi umum |
| Customer Chat | Load Messages | Pesan dari admin |
| Customer Notifications | Page Load | Semua notifikasi |
| Admin Dashboard | Page Load | Semua notifikasi umum |
| Admin Messages | Page Load | Pesan dari customer |
| Admin Chat | Select Customer | Pesan dari customer yang dipilih |

## Catatan Penting

1. **Untuk Production:** Gunakan Pusher.com atau setup Laravel WebSockets server
2. **Untuk Development:** Konfigurasi saat ini sudah cukup dengan fallback polling
3. **Performance:** Real-time updates hanya untuk data penting (notifikasi, pesan)
4. **Browser Compatibility:** Menggunakan modern JavaScript, support browser terbaru
5. **Database:** Sistem menggunakan 2 tabel terpisah (messages & chats) untuk pesan
6. **Auto Mark as Read:** Berfungsi otomatis tanpa perlu user action manual
