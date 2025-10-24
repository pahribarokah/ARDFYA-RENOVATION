@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')
<!-- Enhanced Header Section -->
<div class="relative gradient-bg rounded-xl p-8 mb-8 border border-green-100 card overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-600 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-600 rounded-full translate-y-12 -translate-x-12"></div>
    </div>

    <div class="relative z-10 flex items-center justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg mr-4 md:hidden">
                    <i class="fas fa-user-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-1">Selamat Datang!</h1>
                    <p class="text-lg text-gray-700">Halo, <span class="font-bold text-green-700">{{ Auth::user()->name }}</span> 👋</p>
                </div>
            </div>
            <p class="text-gray-600 max-w-md">Kelola proyek renovasi Anda, pantau progress pekerjaan, dan komunikasi dengan tim kami melalui dashboard ini.</p>
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i>
                    Akun Terverifikasi
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Customer Premium
                </span>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-xl transform hover:scale-105 transition-transform duration-300">
                <i class="fas fa-user-circle text-white text-5xl"></i>
            </div>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Projects -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Proyek</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProjects }}</p>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-green-100 to-green-200 text-green-600">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Proyek Aktif</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $activeProjects }}</p>
                </div>
            </div>
        </div>

        <!-- Total Inquiries -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-600">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total permintaan</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalInquiries }}</p>
                </div>
            </div>
        </div>

        <!-- Total Contracts -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-purple-100 to-purple-200 text-purple-600">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Kontrak</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalContracts }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Projects -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-project-diagram text-green-600 mr-3"></i>
                    Proyek Terbaru
                </h2>
                <a href="{{ route('customer.projects') }}" class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($recentProjects->count() > 0)
                <div class="space-y-4">
                    @foreach($recentProjects as $project)
                        <div class="border-l-4 border-green-600 pl-4 py-2">
                            <h3 class="font-medium text-gray-800">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $project->service->name ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($project->status === 'completed') bg-green-100 text-green-800
                                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($project->status === 'planning') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $project->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada proyek</p>
            @endif
        </div>

        <!-- Recent Inquiries -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    permintaan Terbaru
                </h2>
                <a href="{{ route('customer.inquiries') }}" class="text-green-600 hover:text-green-700 text-sm font-medium transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($recentInquiries->count() > 0)
                <div class="space-y-4">
                    @foreach($recentInquiries as $inquiry)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <h3 class="font-medium text-gray-800">{{ $inquiry->service->name ?? 'N/A' }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($inquiry->description, 50) }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($inquiry->status === 'approved') bg-green-100 text-green-800
                                    @elseif($inquiry->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($inquiry->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada inquiry</p>
            @endif
        </div>
    </div>

    <!-- Chat Notification Card -->
    @php
        // Count unread messages from admin in messages table
        $unreadMessagesFromAdmin = \App\Models\Message::where('is_from_admin', true)
            ->where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // Add unread chats from admin
        $unreadChatsFromAdmin = \App\Models\Chat::where('is_from_admin', true)
            ->where('customer_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $unreadMessagesFromAdmin += $unreadChatsFromAdmin;
    @endphp

    @if($unreadMessagesFromAdmin > 0)
    <div class="chat-notification-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 mb-8 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Chat dengan Admin</h3>
                    <p class="text-purple-100">Hubungi tim kami</p>
                </div>
            </div>
            <div class="text-right">
                <span class="notification-count bg-red-500 text-white text-sm px-3 py-1 rounded-full font-bold">{{ $unreadMessagesFromAdmin }}</span>
                <p class="text-purple-100 text-sm mt-1">Pesan baru</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('messages.customer') }}" class="inline-flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-all duration-200">
                <span class="mr-2">Lihat Pesan</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-3"></i>
            Aksi Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('inquiries.create') }}" class="group bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-opacity-30 transition-all">
                    <i class="fas fa-plus-circle text-2xl"></i>
                </div>
                <p class="font-semibold text-lg">Buat permintaan Baru</p>
                <p class="text-green-100 text-sm mt-1">Mulai proyek baru</p>
            </a>

            <a href="{{ route('customer.projects') }}" class="group bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-opacity-30 transition-all">
                    <i class="fas fa-project-diagram text-2xl"></i>
                </div>
                <p class="font-semibold text-lg">Lihat Proyek</p>
                <p class="text-blue-100 text-sm mt-1">Pantau progress</p>
            </a>

            <a href="{{ route('messages.customer') }}" class="group bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl relative">
                <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-opacity-30 transition-all">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
                <p class="font-semibold text-lg">Chat dengan Admin</p>
                <p class="text-purple-100 text-sm mt-1">Hubungi tim kami</p>
                @if($unreadMessages > 0)
                    <span class="message-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full shadow-lg animate-pulse">{{ $unreadMessages }}</span>
                @else
                    <span class="message-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full shadow-lg animate-pulse" style="display: none;">0</span>
                @endif
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto mark notifications as read when dashboard is opened
    markNotificationsAsRead();

    function markNotificationsAsRead() {
        // Get all unread notifications and mark them as read
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notifications marked as read');
                // Update notification badges
                if (typeof updateCustomerNotificationBadges === 'function') {
                    updateCustomerNotificationBadges();
                }
            }
        })
        .catch(error => {
            console.error('Error marking notifications as read:', error);
        });
    }
});
</script>
@endpush
