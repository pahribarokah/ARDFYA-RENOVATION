# Frontend dan Views - Aplikasi Ardfya v2

## 1. Gambaran Umum Frontend

Aplikasi Ardfya v2 menggunakan pendekatan modern untuk frontend development dengan kombinasi teknologi yang powerful dan user-friendly:

- **Template Engine**: Blade Templates (Laravel)
- **CSS Framework**: TailwindCSS + Bootstrap 5
- **JavaScript Framework**: Alpine.js
- **Build Tool**: Vite
- **Real-time**: Laravel Echo + Pusher
- **Icons**: Font Awesome 6

## 1.1 Perubahan Setelah Cleanup (v2.1)

### Views yang Dihapus:
- ❌ `welcome.blade.php` (default Laravel, tidak digunakan)
- ❌ `admin/test.blade.php` (testing view)
- ❌ `admin/simple.blade.php` (testing view)

### Optimisasi:
- ✅ Structure lebih bersih dan focused
- ✅ Tidak ada testing views yang exposed
- ✅ Homepage terintegrasi dengan portfolio database
- ✅ Performance loading lebih cepat

## 2. Struktur Views

### 2.1 Layout Templates

#### Main Layout (`layouts/main.blade.php`)
Layout utama untuk halaman publik dengan fitur:
- **Responsive Navigation**: Desktop dan mobile menu
- **Brand Identity**: Logo ARDFYA dengan warna hijau konsisten
- **User Authentication**: Dropdown menu untuk user yang login
- **Mobile-First Design**: Optimized untuk semua device
- **Sticky Header**: Navigation yang tetap terlihat saat scroll
- **Footer**: Informasi kontak dan social media links

**Key Features:**
```php
// Brand Colors
:root {
    --brand-green: #046c4e;
    --brand-green-dark: #03543f;
    --brand-green-light: #047857;
}

// Navigation States
.nav-link.active {
    @apply text-brand-green font-semibold;
}
```

#### Admin Layout (`layouts/admin.blade.php`)
Layout khusus untuk panel admin dengan:
- **Admin Sidebar**: Navigation menu untuk admin functions
- **Dashboard Header**: Admin-specific header dengan logout
- **Content Area**: Main content area untuk admin pages
- **Admin Styling**: Consistent admin theme

#### App Layout (`layouts/app.blade.php`)
Layout untuk authenticated user pages:
- **User Dashboard**: Layout untuk halaman user
- **Profile Management**: User profile sections
- **Message Interface**: Chat dan messaging layout

### 2.2 Public Views Structure (Updated v2.1)

```
resources/views/
├── home/
│   ├── index.blade.php          # Homepage (Portfolio integrated)
│   ├── about.blade.php          # About page
│   ├── contact.blade.php        # Contact page
│   ├── portfolio.blade.php      # Portfolio gallery page
│   └── portfolio-detail.blade.php # Individual portfolio detail
├── home.blade.php               # User dashboard (after login)
├── auth/
│   ├── login.blade.php          # Login form
│   ├── register.blade.php       # Registration form
│   └── passwords/               # Password reset views
├── components/
│   ├── how-it-works.blade.php   # How it works section
│   ├── testimonials.blade.php   # Customer testimonials
│   └── why-choose-us.blade.php  # Why choose us section
├── inquiries/
│   └── create.blade.php         # Inquiry form
└── emails/
    └── contact.blade.php        # Contact email template
```

**Key Changes:**
- ✅ Added `portfolio-detail.blade.php` for individual portfolio pages
- ✅ Homepage now dynamically loads portfolio from database
- ✅ Removed unused testing views

### 2.3 Admin Views Structure (Updated v2.1)

```
resources/views/admin/
├── dashboard.blade.php          # Admin dashboard
├── login.blade.php             # Admin login
├── chat.blade.php              # Admin chat interface
├── inquiries/
│   ├── index.blade.php         # Inquiry list
│   ├── show.blade.php          # Inquiry detail
│   ├── create.blade.php        # Create inquiry
│   └── edit.blade.php          # Edit inquiry
├── projects/
│   ├── index.blade.php         # Project list
│   ├── show.blade.php          # Project detail
│   ├── create.blade.php        # Create project
│   └── edit.blade.php          # Edit project
├── customers/
│   ├── index.blade.php         # Customer list
│   ├── show.blade.php          # Customer detail
│   └── edit.blade.php          # Edit customer
├── contracts/
│   ├── index.blade.php         # Contract list
│   ├── show.blade.php          # Contract detail
│   ├── create.blade.php        # Create contract
│   └── edit.blade.php          # Edit contract
└── portfolios/                  # NEW: Portfolio management
    ├── index.blade.php         # Portfolio list
    ├── show.blade.php          # Portfolio detail
    ├── create.blade.php        # Create portfolio
    └── edit.blade.php          # Edit portfolio
```

**Key Changes:**
- ✅ Added complete portfolio management views
- ✅ Removed testing views (`test.blade.php`, `simple.blade.php`)
- ✅ Cleaner admin structure

### 2.4 User/Customer Views

```
resources/views/
├── profile/
│   └── edit.blade.php          # User profile edit
├── messages/
│   ├── customer.blade.php      # Customer chat interface
│   ├── user.blade.php          # User messages
│   └── admin.blade.php         # Admin messages view
└── inquiries/
    └── create.blade.php        # Create inquiry form
```

## 3. CSS Architecture

### 3.1 TailwindCSS Configuration

```javascript
// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'brand-green': '#4CAF50',
        'brand-green-light': '#8BC34A',
        'brand-green-dark': '#388E3C',
        'brand-green-lighter': '#C8E6C9',
        'brand-green-darker': '#1B5E20',
      },
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
        'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
      },
    },
  },
}
```

### 3.2 Custom CSS Components

```css
/* resources/css/app.css */
@layer components {
  .btn-primary {
    @apply bg-brand-green text-white px-6 py-2 rounded-full 
           hover:bg-brand-green-dark transition duration-300;
  }
  
  .nav-link {
    @apply relative pb-1 text-gray-700 hover:text-brand-green 
           transition-colors;
  }
  
  .card {
    @apply bg-white rounded-xl shadow-lg transition-all duration-300;
  }
  
  .card:hover {
    @apply transform -translate-y-1 shadow-xl;
  }
}
```

### 3.3 Brand Identity

**Color Palette:**
- **Primary Green**: `#046c4e` (green-700)
- **Dark Green**: `#03543f` (green-800)
- **Light Green**: `#047857` (green-600)
- **Accent Colors**: Gray scale untuk text dan backgrounds

**Typography:**
- **Font Family**: Inter (Google Fonts)
- **Font Weights**: 400, 500, 600, 700
- **Responsive Typography**: Tailwind responsive classes

## 4. JavaScript Architecture

### 4.1 Alpine.js Implementation

```javascript
// resources/js/app.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
});
```

**Alpine.js Usage Examples:**
```html
<!-- Dropdown Menu -->
<div x-data="{ open: false }">
    <button @click="open = !open">Menu</button>
    <div x-show="open" @click.away="open = false">
        <!-- Dropdown content -->
    </div>
</div>

<!-- Modal -->
<div x-data="{ showModal: false }">
    <button @click="showModal = true">Open Modal</button>
    <div x-show="showModal" x-transition>
        <!-- Modal content -->
    </div>
</div>
```

### 4.2 Real-time Features

```javascript
// resources/js/bootstrap.js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
});
```

### 4.3 Custom JavaScript Features

**Mobile Menu Toggle:**
```javascript
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuButton.addEventListener('click', function() {
    mobileMenu.classList.toggle('hidden');
});
```

**Smooth Scrolling:**
```javascript
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({ behavior: 'smooth' });
    });
});
```

**Chat Functionality:**
```javascript
function sendMessage() {
    const messageText = chatInput.value.trim();
    if (messageText) {
        appendMessage(messageText, 'user');
        chatInput.value = '';
        // Send to server via AJAX
    }
}
```

## 5. Component System

### 5.1 Reusable Blade Components

#### How It Works Component
```php
<!-- components/how-it-works.blade.php -->
<section id="cara-kerja" class="section-padding bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Cara Kerja</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Steps -->
        </div>
    </div>
</section>
```

#### Testimonials Component
```php
<!-- components/testimonials.blade.php -->
<section id="testimoni" class="section-padding">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Testimoni Pelanggan</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Testimonial cards -->
        </div>
    </div>
</section>
```

### 5.2 Form Components

**Inquiry Form:**
```html
<form method="POST" action="{{ route('inquiries.store') }}" class="space-y-6">
    @csrf
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap *
            </label>
            <input type="text" name="name" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                          focus:ring-2 focus:ring-brand-green focus:border-transparent">
        </div>
        <!-- More form fields -->
    </div>
</form>
```

### 5.3 Card Components

**Service Card:**
```html
<div class="card p-6 text-center group">
    <div class="w-16 h-16 bg-brand-green rounded-full flex items-center 
                justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
        <i class="{{ $service->icon }} text-white text-2xl"></i>
    </div>
    <h3 class="text-xl font-semibold mb-3">{{ $service->name }}</h3>
    <p class="text-gray-600 mb-4">{{ $service->short_description }}</p>
    <a href="{{ route('services.show', $service) }}" 
       class="btn-primary inline-block">Lihat Detail</a>
</div>
```

## 6. Responsive Design

### 6.1 Breakpoint Strategy

```css
/* Mobile First Approach */
.container {
    @apply px-4;          /* Mobile: 16px padding */
}

@media (min-width: 640px) {
    .container {
        @apply px-6;      /* Tablet: 24px padding */
    }
}

@media (min-width: 1024px) {
    .container {
        @apply px-8;      /* Desktop: 32px padding */
    }
}
```

### 6.2 Grid System

```html
<!-- Responsive Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Grid items -->
</div>

<!-- Responsive Flexbox -->
<div class="flex flex-col md:flex-row items-center gap-6">
    <!-- Flex items -->
</div>
```

### 6.3 Mobile Optimization

**Mobile Menu:**
```html
<div class="md:hidden">
    <button id="mobile-menu-button" class="text-gray-700 hover:text-green-700">
        <i class="fas fa-bars fa-lg"></i>
    </button>
</div>

<div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
    <!-- Mobile navigation items -->
</div>
```

## 7. Asset Management

### 7.1 Vite Configuration

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

### 7.2 Asset Loading

```php
<!-- In Blade templates -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- External CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
```

### 7.3 Image Optimization

```html
<!-- Responsive Images -->
<img src="{{ asset('images/hero-bg.jpg') }}" 
     alt="Hero Background"
     class="w-full h-auto object-cover"
     loading="lazy">

<!-- Placeholder for missing images -->
<div class="w-full h-48 bg-gray-200 flex items-center justify-center">
    <i class="fas fa-image text-gray-400 text-3xl"></i>
</div>
```

## 8. Performance Optimization

### 8.1 CSS Optimization
- **PurgeCSS**: Automatic unused CSS removal
- **Critical CSS**: Above-the-fold CSS inlining
- **CSS Minification**: Production build optimization

### 8.2 JavaScript Optimization
- **Code Splitting**: Separate chunks for different pages
- **Lazy Loading**: Load components when needed
- **Tree Shaking**: Remove unused JavaScript

### 8.3 Image Optimization
- **Lazy Loading**: Images load when in viewport
- **WebP Format**: Modern image format support
- **Responsive Images**: Different sizes for different screens

---

*Frontend architecture ini dirancang untuk memberikan user experience yang optimal dengan performance yang cepat, design yang responsive, dan maintainability yang baik.*
