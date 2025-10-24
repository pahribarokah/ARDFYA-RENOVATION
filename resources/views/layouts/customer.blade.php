<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Dashboard') - {{ config('app.name', 'ARDFYA') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        :root {
            --brand-green: #15803d;
            --brand-green-dark: #166534;
            --brand-green-light: #16a34a;
        }

        .card {
            @apply bg-white rounded-xl shadow-lg border border-gray-100 transition-all duration-300;
        }
        .card:hover {
            @apply shadow-xl transform -translate-y-1;
        }

        .btn {
            @apply px-6 py-3 rounded-lg font-semibold transition-all duration-300 inline-flex items-center justify-center;
        }
        .btn:hover {
            @apply transform -translate-y-1 shadow-lg;
        }
        .btn-primary {
            @apply bg-gradient-to-r from-green-600 to-green-700 text-white;
        }
        .btn-primary:hover {
            @apply from-green-700 to-green-800;
        }

        .stat-card {
            @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100;
        }
        .stat-icon {
            @apply p-3 rounded-full text-xl;
        }

        .nav-brand {
            @apply text-2xl font-bold text-green-700 tracking-tight hover:text-green-800 transition-colors;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <div id="app" class="flex flex-col min-h-screen">
        <!-- Customer Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold text-green-700 hover:text-green-800 transition-colors tracking-tight">
                            {{ config('app.name', 'ARDFYA') }}
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <!-- Main Navigation -->
                        <a href="{{ route('customer.dashboard') }}"
                           class="nav-link text-gray-700 hover:text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customer.dashboard') ? 'text-green-700 bg-green-50 shadow-sm' : '' }}">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>

                        <a href="{{ route('customer.projects') }}"
                           class="nav-link text-gray-700 hover:text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customer.projects*') ? 'text-green-700 bg-green-50 shadow-sm' : '' }}">
                            <i class="fas fa-project-diagram mr-2"></i>Proyek Saya
                        </a>

                        <a href="{{ route('customer.inquiries') }}"
                           class="nav-link text-gray-700 hover:text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customer.inquiries') ? 'text-green-700 bg-green-50 shadow-sm' : '' }}">
                            <i class="fas fa-question-circle mr-2"></i>Inquiry
                        </a>

                        <a href="{{ route('customer.contracts') }}"
                           class="nav-link text-gray-700 hover:text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customer.contracts*') ? 'text-green-700 bg-green-50 shadow-sm' : '' }}">
                            <i class="fas fa-file-contract mr-2"></i>Kontrak
                        </a>

                        <!-- Quick Actions -->
                        <div class="border-l border-gray-300 pl-8 ml-8">
                            <a href="{{ route('home') }}"
                               class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-home mr-2"></i>Beranda
                            </a>

                            <a href="{{ route('inquiries.create') }}"
                               class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-plus-circle mr-2"></i>Buat Inquiry
                            </a>
                        </div>



                        <!-- User Menu -->
                        <div class="relative ml-8" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center text-gray-700 hover:text-green-600 transition-colors px-3 py-2 rounded-md text-sm font-medium focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('customer.profile') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Profil Saya
                                    </a>
                                    <a href="{{ route('customer.notification-settings') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i>Pengaturan Notifikasi
                                    </a>
                                    <a href="{{ route('messages.customer') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-comments mr-2"></i>Chat Admin
                                    </a>
                                    <a href="{{ route('inquiries.create') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-plus mr-2"></i>Buat Inquiry
                                    </a>

                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" aria-label="Toggle menu" @click="mobileMenuOpen = !mobileMenuOpen">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" 
                 x-data="{ mobileMenuOpen: false }"
                 class="md:hidden bg-white border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <!-- Customer Menu -->
                    <a href="{{ route('customer.dashboard') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md {{ request()->routeIs('customer.dashboard') ? 'text-brand-green bg-green-50' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('customer.projects') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md {{ request()->routeIs('customer.projects*') ? 'text-brand-green bg-green-50' : '' }}">
                        <i class="fas fa-project-diagram mr-2"></i>Proyek Saya
                    </a>
                    <a href="{{ route('customer.inquiries') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md {{ request()->routeIs('customer.inquiries') ? 'text-brand-green bg-green-50' : '' }}">
                        <i class="fas fa-question-circle mr-2"></i>Inquiry
                    </a>
                    <a href="{{ route('customer.contracts') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md {{ request()->routeIs('customer.contracts*') ? 'text-brand-green bg-green-50' : '' }}">
                        <i class="fas fa-file-contract mr-2"></i>Kontrak
                    </a>
                    
                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-2"></div>
                    
                    <!-- Quick Actions -->
                    <a href="{{ route('home') }}"
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-md">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('inquiries.create') }}"
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-md">
                        <i class="fas fa-plus-circle mr-2"></i>Buat Inquiry
                    </a>
                    
                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-2"></div>
                    
                    <!-- User Menu -->
                    <a href="{{ route('customer.profile') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md">
                        <i class="fas fa-user mr-2"></i>Profil Saya
                    </a>
                    <a href="{{ route('messages.customer') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-brand-green hover:bg-green-50 rounded-md">
                        <i class="fas fa-comments mr-2"></i>Chat Admin
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:bg-red-50 rounded-md">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-sm mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'ARDFYA') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Real-time Notification Script for Customer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time notification updates for customer
            if (window.Echo && {{ Auth::check() && Auth::user()->role === 'customer' ? 'true' : 'false' }}) {
                try {
                    const userId = {{ Auth::id() ?? 'null' }};

                    // Listen for new messages in customer chat
                    window.Echo.private(`chat.${userId}`)
                        .listen('.new.chat.message', (e) => {
                            console.log('New message received:', e);
                            updateCustomerNotificationBadges();
                        });

                    // Listen for inquiry status updates
                    window.Echo.private(`user.${userId}`)
                        .listen('.inquiry.status.updated', (e) => {
                            console.log('Inquiry status updated:', e);
                            updateCustomerNotificationBadges();
                        });

                    // Listen for project updates
                    window.Echo.private(`user.${userId}`)
                        .listen('.project.updated', (e) => {
                            console.log('Project updated:', e);
                            updateCustomerNotificationBadges();
                        });

                    console.log('Customer notification listeners initialized');
                } catch (error) {
                    console.error('Echo setup error:', error);
                }
            }

            // Function to update customer notification badges
            function updateCustomerNotificationBadges() {
                fetch('/api/notifications/count', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update notification badge (if exists in customer layout)
                    const notificationBadge = document.querySelector('.notification-badge');
                    if (notificationBadge) {
                        if (data.count > 0) {
                            notificationBadge.textContent = data.count > 99 ? '99+' : data.count;
                            notificationBadge.style.display = 'flex';
                        } else {
                            notificationBadge.style.display = 'none';
                        }
                    }

                    // Update message badges if present
                    const messageBadges = document.querySelectorAll('.message-badge');
                    messageBadges.forEach(badge => {
                        if (data.messageCount > 0) {
                            badge.textContent = data.messageCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    });

                    // Update chat notification card if present
                    const chatNotificationCard = document.querySelector('.chat-notification-card');
                    if (chatNotificationCard) {
                        const badge = chatNotificationCard.querySelector('.notification-count');
                        if (data.messageCount > 0) {
                            if (badge) {
                                badge.textContent = data.messageCount;
                                badge.style.display = 'block';
                            }
                            chatNotificationCard.style.display = 'block';
                        } else {
                            if (badge) {
                                badge.style.display = 'none';
                            }
                        }
                    }
                })
                .catch(error => console.error('Error updating customer notification badges:', error));
            }

            // Initial badge update
            updateCustomerNotificationBadges();

            // Periodic update as fallback (every 30 seconds)
            setInterval(updateCustomerNotificationBadges, 30000);
        });
    </script>
</body>
</html>
