<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ARDFYA'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Specific Styles -->
    @yield('styles')

    <!-- Consistent Styling -->
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
        .btn-secondary {
            @apply bg-white text-green-700 border-2 border-green-700;
        }
        .btn-secondary:hover {
            @apply bg-green-700 text-white;
        }

        .stat-card {
            @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100;
        }
        .stat-icon {
            @apply p-3 rounded-full text-xl;
        }

        .nav-brand {
            @apply text-xl font-bold text-green-600 hover:text-green-700 transition-colors;
        }

        .form-input {
            @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }

        .table-responsive {
            @apply overflow-x-auto shadow-lg rounded-xl;
        }
        .table {
            @apply min-w-full bg-white;
        }
        .table th {
            @apply px-6 py-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }
        .table td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200;
        }
        .table tbody tr:hover {
            @apply bg-gray-50;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div id="app" class="flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a class="text-xl font-bold text-green-600 hover:text-green-700 transition-colors" href="{{ url('/') }}">
                            {{ config('app.name', 'ARDFYA') }}
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none" aria-label="Toggle menu">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        @guest
                            @if (Route::has('login'))
                                <a class="text-gray-700 hover:text-green-600 transition-colors px-3 py-2 rounded-md text-sm font-medium" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif

                            @if (Route::has('register'))
                                <a class="text-gray-700 hover:text-green-600 transition-colors px-3 py-2 rounded-md text-sm font-medium" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <!-- Messages Link -->
                            <a href="{{ route('messages.customer') }}" class="relative text-gray-700 hover:text-green-600 transition-colors px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-comments mr-1"></i>
                                <span>Messages</span>
                                @php
                                    $unreadCount = 0;
                                    if (Auth::check()) {
                                        $user = Auth::user();
                                        foreach ($user->inquiries as $inquiry) {
                                            $unreadCount += $inquiry->messages()->where('is_from_admin', true)->where('is_read', false)->count();
                                        }
                                        foreach ($user->projects as $project) {
                                            $unreadCount += $project->messages()->where('is_from_admin', true)->where('is_read', false)->count();
                                        }
                                    }
                                @endphp
                                @if ($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-gray-700 hover:text-green-600 transition-colors px-3 py-2 rounded-md text-sm font-medium focus:outline-none">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    @if(Auth::user()->role === 'customer')
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('customer.profile') }}">
                                            Profile
                                        </a>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('customer.dashboard') }}">
                                            Dashboard
                                        </a>
                                    @elseif(Auth::user()->role === 'admin')
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.dashboard') }}">
                                            Admin Panel
                                        </a>
                                    @endif

                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
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

    <!-- Chat Popup -->
    @auth
    <div id="chat-popup-container" class="fixed bottom-5 right-5 z-50">
        <!-- Chat Button -->
        <button id="chat-button" class="bg-green-600 hover:bg-green-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </button>
        
        <!-- Chat Window -->
        <div id="chat-window" class="hidden bg-white rounded-lg shadow-xl w-80 md:w-96 overflow-hidden">
            <div class="bg-green-600 text-white px-4 py-3 flex justify-between items-center">
                <h3 class="font-medium">Customer Support</h3>
                <button id="close-chat" class="text-white hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div id="chat-messages" class="h-80 overflow-y-auto p-4 bg-gray-50">
                <div class="text-center text-gray-500 py-4">
                    <p>Loading messages...</p>
                </div>
            </div>
            <div class="p-3 border-t">
                <form id="chat-form" class="flex">
                    <input type="text" id="chat-input" class="flex-1 border rounded-l-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Type your message...">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const closeChat = document.getElementById('close-chat');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
            
            if (chatButton) {
                chatButton.addEventListener('click', function() {
                    if (chatWindow) {
                        chatWindow.classList.toggle('hidden');
                        if (!chatWindow.classList.contains('hidden')) {
                            loadMessages();
                        }
                    }
                });
            }
            
            if (closeChat) {
                closeChat.addEventListener('click', function() {
                    if (chatWindow) {
                        chatWindow.classList.add('hidden');
                    }
                });
            }
            
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (!chatInput) return;
                    
                    const message = chatInput.value.trim();
                    if (!message) return;
                    
                    sendMessage(message);
                    chatInput.value = '';
                });
            }
            
            function loadMessages() {
                fetch('/chat/messages', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (chatMessages) {
                        displayMessages(data);
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    if (chatMessages) {
                        chatMessages.innerHTML = '<p class="text-red-500 text-center py-4">Error loading messages. Please try again.</p>';
                    }
                });
            }
            
            function displayMessages(messages) {
                if (!chatMessages) return;
                
                if (messages.length === 0) {
                    chatMessages.innerHTML = '<p class="text-center text-gray-500 py-4">No messages yet. Start a conversation!</p>';
                    return;
                }
                
                let html = '';
                messages.forEach(msg => {
                    const isFromMe = !msg.is_from_admin;
                    const messageClass = isFromMe 
                        ? 'bg-green-100 ml-auto' 
                        : 'bg-gray-100 mr-auto';
                    
                    html += `
                        <div class="flex flex-col mb-4 max-w-[80%] ${isFromMe ? 'items-end' : 'items-start'}">
                            <div class="${messageClass} rounded-lg px-3 py-2">
                                <p>${msg.message}</p>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    `;
                });
                
                chatMessages.innerHTML = html;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            
            function sendMessage(message) {
                fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadMessages();
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            }
        });
    </script>
    @endauth
</body>
</html>
