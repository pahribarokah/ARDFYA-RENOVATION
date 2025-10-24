<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ARDFYA - Solusi Renovasi dan Perbaikan Rumah Anda')</title>
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --brand-green: #15803d; /* green-700 */
            --brand-green-dark: #166534; /* green-800 */
            --brand-green-light: #16a34a; /* green-600 */
            --brand-blue: #3b82f6;
            --brand-purple: #8b5cf6;
            --brand-yellow: #f59e0b;
            --brand-red: #ef4444;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        html, body {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        .text-brand-green {
            color: var(--brand-green);
        }
        
        .bg-brand-green {
            background-color: var(--brand-green);
        }
        
        .border-brand-green {
            border-color: var(--brand-green);
        }
        
        .hover\:bg-brand-green:hover {
            background-color: var(--brand-green);
        }
        
        .hover\:text-brand-green:hover {
            color: var(--brand-green);
        }
        
        .focus\:ring-brand-green:focus {
            --tw-ring-color: var(--brand-green);
        }
        
        .hover\:bg-brand-green-dark:hover {
            background-color: var(--brand-green-dark);
        }
        
        .nav-link {
            @apply text-gray-700 hover:text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 ease-in-out;
            position: relative;
            border: 1px solid transparent;
        }
        .nav-link:hover {
            @apply bg-green-50 transform scale-105;
            box-shadow: 0 4px 12px rgba(21, 128, 61, 0.15);
            transform: translateY(-1px) scale(1.02);
        }
        .nav-link.active {
            @apply text-green-700 bg-green-50 font-semibold shadow-sm;
            background: linear-gradient(135deg, rgba(21, 128, 61, 0.1), rgba(22, 101, 52, 0.1)) !important;
            border: 1px solid rgba(21, 128, 61, 0.2);
            font-weight: 700;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: linear-gradient(135deg, #15803d, #166534);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(21, 128, 61, 0.3);
        }
        .section-padding {
            @apply py-12 md:py-20;
        }

        /* Enhanced Card Styles */
        .card {
            @apply bg-white rounded-xl shadow-lg border border-gray-100 transition-all duration-300;
        }
        .card:hover {
            @apply shadow-xl transform -translate-y-1;
        }

        /* Enhanced Button Styles */
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
        .btn-secondary {
            @apply bg-white text-green-700 border-2 border-green-700;
        }
        .btn-secondary:hover {
            @apply bg-green-700 text-white;
        }

        /* Enhanced Form Styles */
        .form-input {
            @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }

        /* Enhanced Stats Cards */
        .stat-card {
            @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100;
        }
        .stat-icon {
            @apply p-3 rounded-full text-xl;
        }

        /* Enhanced Navigation */
        .nav-brand {
            @apply text-3xl font-bold text-green-700 tracking-tight hover:text-green-800 transition-colors;
        }
        /* Custom scrollbar for modal if needed */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background-color: #cbd5e1; /* gray-300 */
            border-radius: 4px;
        }
        .modal-content::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8; /* gray-400 */
        }
        
        /* Modern Animations */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(21, 128, 61, 0.3); }
            50% { box-shadow: 0 0 30px rgba(21, 128, 61, 0.6); }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-800 { animation-delay: 0.8s; }
        .delay-1000 { animation-delay: 1s; }

        /* Enhanced Hero Section */
        #beranda {
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }

        #beranda::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(21, 128, 61, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(34, 197, 94, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Glassmorphism Effects */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Enhanced Button Styles */
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        /* Fix for zoom issues */
        @media screen and (max-width: 640px) {
            .container {
                width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="bg-white text-gray-800 antialiased">
    <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 transition-all duration-300 border-b border-gray-100">
        <nav class="container mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <!-- Enhanced Logo -->
            <a href="{{ route('home') }}" class="group flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                    <span class="text-white font-bold text-lg">A</span>
                </div>
                <span class="text-2xl font-black text-gray-800 tracking-tight group-hover:text-green-700 transition-colors duration-300">ARDFYA</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('home') }}#beranda" class="nav-link group relative px-4 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="relative z-10">Beranda</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="#layanan" class="nav-link group relative px-4 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold" onclick="handleServiceNavigation(event)">
                    <span class="relative z-10">Layanan</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('home') }}#portofolio" class="nav-link group relative px-4 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold">
                    <span class="relative z-10">Portofolio</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('home') }}#tentang-kami" class="nav-link group relative px-4 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold">
                    <span class="relative z-10">Tentang Kami</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('contact') }}" class="nav-link group relative px-4 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <span class="relative z-10">Kontak</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('messages.customer') }}" class="nav-link group relative px-3 py-2.5 rounded-xl text-gray-700 hover:text-green-700 transition-all duration-300 font-semibold {{ request()->routeIs('messages.customer') ? 'active' : '' }}" title="Pesan">
                    <span class="relative z-10"><i class="fas fa-comments"></i></span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-green-100 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                @guest
                    <a href="{{ route('login') }}" class="ml-6 group relative overflow-hidden bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            Login
                        </span>
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    </a>
                @else
                    <div class="relative ml-6" x-data="{ open: false }">
                        <button @click="open = !open" class="group flex items-center focus:outline-none text-sm bg-gray-50 hover:bg-gray-100 px-4 py-2.5 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-300">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform duration-300">
                                <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-gray-700 group-hover:text-green-700 font-semibold mr-2">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 fill-current text-gray-500 group-hover:text-green-600 transition-all duration-300" :class="{ 'rotate-180': open }" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-100 backdrop-blur-sm">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-700 transition-all duration-200 rounded-xl mx-2">
                                    <i class="fas fa-tachometer-alt mr-3 text-green-600 group-hover:scale-110 transition-transform duration-200"></i>
                                    Dashboard Admin
                                </a>
                            @elseif(Auth::user()->role === 'customer')
                                <a href="{{ route('customer.profile') }}" class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 transition-all duration-200 rounded-xl mx-2">
                                    <i class="fas fa-user mr-3 text-blue-600 group-hover:scale-110 transition-transform duration-200"></i>
                                    Profil
                                </a>
                                <a href="{{ route('customer.dashboard') }}" class="group flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-700 transition-all duration-200 rounded-xl mx-2">
                                    <i class="fas fa-tachometer-alt mr-3 text-green-600 group-hover:scale-110 transition-transform duration-200"></i>
                                    Dashboard
                                </a>
                            @endif
                            <div class="border-t border-gray-100 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="group flex items-center w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:text-red-600 transition-all duration-200 rounded-xl mx-2">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:scale-110 transition-transform duration-200"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="group relative p-2 text-gray-700 hover:text-green-700 focus:outline-none transition-all duration-300 rounded-xl hover:bg-green-50">
                    <div class="w-6 h-6 flex flex-col justify-center items-center">
                        <span class="block w-5 h-0.5 bg-current transition-all duration-300 group-hover:w-6"></span>
                        <span class="block w-6 h-0.5 bg-current mt-1 transition-all duration-300"></span>
                        <span class="block w-4 h-0.5 bg-current mt-1 transition-all duration-300 group-hover:w-6"></span>
                    </div>
                </button>
            </div>
        </nav>
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg border-t border-gray-100">
            <a href="{{ route('home') }}#beranda" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Beranda</a>
            <a href="#layanan" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200" onclick="handleServiceNavigation(event)">Layanan</a>
            <a href="{{ route('home') }}#portofolio" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Portofolio</a>
            <a href="{{ route('home') }}#tentang-kami" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Tentang Kami</a>
            <a href="{{ route('contact') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Kontak</a>
            @guest
                <a href="{{ route('login') }}" class="block px-6 py-3 bg-green-700 text-white text-center hover:bg-green-800 transition-colors duration-300 font-semibold">Login</a>
            @else
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Dashboard Admin</a>
                @elseif(Auth::user()->role === 'customer')
                    <a href="{{ route('customer.profile') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Profil</a>
                    <a href="{{ route('customer.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Dashboard</a>
                @endif
                <a href="{{ route('messages.customer') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-green-700 transition-colors duration-200">Pesan</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-6 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">Logout</button>
                </form>
            @endguest
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400 py-10 md:py-16 mt-auto">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-green-600 mb-4">ARDFYA</h3>
                    <p class="text-sm leading-relaxed">Solusi renovasi dan perbaikan rumah terpercaya dengan kualitas terbaik dan desain yang menawan.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-white mb-3">Menu Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}#beranda" class="hover:text-white transition-colors duration-300">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-white transition-colors duration-300" onclick="handleServiceNavigation(event)">Layanan</a></li>
                        <li><a href="{{ route('home') }}#portofolio" class="hover:text-white transition-colors duration-300">Portofolio</a></li>
                        <li><a href="{{ route('home') }}#tentang-kami" class="hover:text-white transition-colors duration-300">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors duration-300">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-white mb-3">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-green-600 flex-shrink-0"></i>
                            <span>Jl. Contoh No. 123, Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-green-600"></i>
                            <a href="tel:+621234567890" class="hover:text-white transition-colors duration-300">+62 123 4567 890</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-green-600"></i>
                            <a href="mailto:info@ardfya.com" class="hover:text-white transition-colors duration-300">info@ardfya.com</a>
                        </li>
                    </ul>
                    <div class="mt-4 flex space-x-3">
                        <a href="#" class="text-lg hover:text-white transition-colors duration-300"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-lg hover:text-white transition-colors duration-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-lg hover:text-white transition-colors duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-lg hover:text-white transition-colors duration-300"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} ARDFYA. All rights reserved.</p>
            </div>
        </div>
    </footer>




    <script>
        // Handle service navigation
        function handleServiceNavigation(event) {
            // If we're on homepage, scroll to services section
            if (window.location.pathname === '/') {
                event.preventDefault();
                const servicesSection = document.getElementById('layanan');
                if (servicesSection) {
                    const headerOffset = document.querySelector('header').offsetHeight || 70;
                    const elementPosition = servicesSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });

                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                } else {
                    // If services section not found, go to services page
                    window.location.href = '/services';
                }
            } else {
                // If not on homepage, go to homepage with services anchor
                window.location.href = '/#layanan';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Chat widget functionality (using Alpine.js for window toggle, manual for messages)
            const chatButton = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const chatInput = document.getElementById('chat-input');
            const chatSend = document.getElementById('chat-send');
            const chatMessagesContainer = document.getElementById('chat-messages');

            if (chatButton && chatWindow) {
                chatButton.addEventListener('click', function() {
                    if (chatWindow.__x) {
                        const alpineData = chatWindow.__x.$data;
                        alpineData.open = !alpineData.open;
                    }
                });
            }
            
            if (chatSend && chatInput && chatMessagesContainer) {
                chatSend.addEventListener('click', sendMessage);
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });
                
                function sendMessage() {
                    const messageText = chatInput.value.trim();
                    if (messageText) {
                        appendMessage(messageText, 'user');
                        chatInput.value = '';
                        chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
                        
                        // Simulate admin reply
                        setTimeout(function() {
                            appendMessage('Terima kasih atas pesan Anda. Tim kami akan segera merespons.', 'admin');
                            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
                        }, 1200);
                    }
                }

                function appendMessage(text, sender) {
                    const messageWrapper = document.createElement('div');
                    messageWrapper.className = 'flex';

                    const messageBubble = document.createElement('div');
                    messageBubble.className = 'rounded-lg p-3 max-w-[80%] text-sm';
                    
                    const senderName = document.createElement('div');
                    senderName.className = 'font-semibold mb-0.5 text-xs';
                    
                    const messageContent = document.createElement('div');
                    messageContent.textContent = text;

                    if (sender === 'user') {
                        messageWrapper.classList.add('justify-end');
                        messageBubble.classList.add('bg-green-700', 'text-white');
                        senderName.classList.add('text-green-200');
                        senderName.textContent = 'Anda';
                    } else {
                        messageBubble.classList.add('bg-gray-200', 'text-gray-800');
                        senderName.classList.add('text-green-700');
                        senderName.textContent = 'Admin ARDFYA';
                    }
                    
                    messageBubble.appendChild(senderName);
                    messageBubble.appendChild(messageContent);
                    messageWrapper.appendChild(messageBubble);
                    chatMessagesContainer.appendChild(messageWrapper);
                }
            }

            // Smooth scroll for internal links
            document.querySelectorAll('a[href^="{{ route('home') }}#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    const targetId = href.substring(href.indexOf('#'));
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        e.preventDefault();
                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                        
                        const headerOffset = document.querySelector('header').offsetHeight || 70;
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "smooth"
                        });

                        // Update active nav link (simple version)
                        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });

            // Active nav link on scroll (simplified)
            const sections = document.querySelectorAll('section[id]');
            
            if (sections.length > 0) {
                window.addEventListener('scroll', navHighlighter);

                function navHighlighter() {
                    let scrollY = window.pageYOffset;
                    const headerHeight = document.querySelector('header').offsetHeight;

                    sections.forEach(current => {
                        const sectionHeight = current.offsetHeight;
                        const sectionTop = current.offsetTop - headerHeight - 50; // Add some offset
                        let sectionId = current.getAttribute('id');
                        
                        /* If our current scroll position enters the space where current section on screen is, add .active class to corresponding navigation link, else remove it */
                        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
                            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                            const targetNavLink = document.querySelector('header nav a[href*="' + sectionId + '"]');
                            if (targetNavLink) {
                                targetNavLink.classList.add('active');
                            }
                        }
                    });
                    
                    // If at the top, make 'Beranda' active
                    if (scrollY < sections[0].offsetTop - headerHeight - 50) {
                        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
                        const berandaLink = document.querySelector('header nav a[href*="#beranda"]');
                        if (berandaLink) {
                            berandaLink.classList.add('active');
                        }
                    }
                }
            }
        });
    </script>
    @yield('scripts')
</body>
</html> 