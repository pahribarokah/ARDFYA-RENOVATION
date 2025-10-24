<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - ARDFYA')</title>
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">

    <aside class="w-64 bg-gray-900 text-gray-200 p-5 space-y-6 fixed top-0 left-0 h-full shadow-xl z-20">
        <div class="text-center py-2">
            <h2 class="text-2xl font-bold text-white">Admin Panel</h2>
            <p class="text-xs text-green-300">ARDFYA Renovation</p>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.inquiries.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Permintaan
            </a>
            <a href="{{ route('admin.projects.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.projects.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Proyek
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3"></path></svg>
                Pelanggan
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.contracts.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Kontrak
            </a>
            <a href="{{ route('admin.portfolios.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.portfolios.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Portfolio
            </a>
            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-brand-green text-white' : 'hover:bg-brand-green-dark hover:text-white' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    Pesan
                </div>
                @php
                    // Get unread message count for admin (messages + chats)
                    $unreadCount = 0;
                    if (Auth::check() && Auth::user()->isAdmin()) {
                        $unreadCount = \App\Models\Message::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        // Add unread chats from customers
                        $unreadChats = \App\Models\Chat::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        $unreadCount += $unreadChats;
                    }
                @endphp
                @if ($unreadCount > 0)
                    <span class="message-badge bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @else
                    <span class="message-badge bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">
                        0
                    </span>
                @endif
            </a>
        </nav>
        <div class="absolute bottom-5 left-5 right-5 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} ARDFYA
        </div>
    </aside>

    <main class="ml-64 p-6 md:p-8">
        <header class="card bg-white shadow-lg rounded-xl p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="mb-4 md:mb-0">
                    @yield('header', '<h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>')
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('home') }}" class="p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Ke Halaman Utama">
                            <i class="fas fa-home"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div>
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add current year to copyright
            const yearElement = document.getElementById('currentYear');
            if (yearElement) {
                yearElement.textContent = new Date().getFullYear();
            }

            // Real-time notification updates for admin
            if (window.Echo && {{ Auth::check() && Auth::user()->isAdmin() ? 'true' : 'false' }}) {
                try {
                    // Listen for new messages
                    window.Echo.private('admin.chat')
                        .listen('.new.chat.message', (e) => {
                            console.log('New message received:', e);
                            updateNotificationBadges();
                        });

                    // Listen for new inquiries
                    window.Echo.channel('admin.notifications')
                        .listen('.new.inquiry', (e) => {
                            console.log('New inquiry received:', e);
                            updateNotificationBadges();
                        });

                    console.log('Admin notification listeners initialized');
                } catch (error) {
                    console.error('Echo setup error:', error);
                }
            }

            // Function to update notification badges
            function updateNotificationBadges() {
                // Update message badges in dashboard and sidebar
                fetch('/api/notifications/count', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update notification badge (bell icon removed from admin header)
                    // Only update message badges now

                    // Update message count in dashboard if present
                    const messageCountElements = document.querySelectorAll('.message-count');
                    messageCountElements.forEach(element => {
                        if (data.messageCount !== undefined) {
                            element.textContent = data.messageCount;
                        }
                    });

                    // Update message badges in sidebar and dashboard
                    const messageBadges = document.querySelectorAll('.message-badge');
                    messageBadges.forEach(badge => {
                        if (data.messageCount > 0) {
                            badge.textContent = data.messageCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    });
                })
                .catch(error => console.error('Error updating notification badges:', error));
            }

            // Initial badge update
            updateNotificationBadges();

            // Periodic update as fallback (every 30 seconds)
            setInterval(updateNotificationBadges, 30000);
        });
    </script>
    @yield('scripts')
</body>
</html> 