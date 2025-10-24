@extends('layouts.admin')

@section('title', 'Dashboard Admin - ARDFYA')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Selamat datang di panel administrasi ARDFYA</p>
    </div>
    <div class="hidden md:flex items-center space-x-4">
        <div class="text-right">
            <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
            <p class="text-xs text-gray-400">{{ now()->format('H:i') }} WIB</p>
        </div>
        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
            <i class="fas fa-user-shield text-white text-xl"></i>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-4 sr-only">Ringkasan Umum</h3>
    
    @if(isset($error))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p class="font-bold">Error</p>
        <p>{{ $error }}</p>
    </div>
    @endif
    
    @if($orphanedInquiriesCount > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-lg flex justify-between items-center">
        <div>
            <h4 class="font-semibold text-yellow-800">Ditemukan {{ $orphanedInquiriesCount }} permintaan tanpa asosiasi pelanggan</h4>
            <p class="text-sm text-yellow-700">Permintaan ini perlu diperbaiki agar terhubung dengan akun pelanggan.</p>
        </div>
        <form action="{{ route('admin.inquiries.fix') }}" method="POST">
            @csrf
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm shadow-sm">
                Perbaiki Sekarang
            </button>
        </form>
    </div>
    @endif
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Customer Card -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Pelanggan</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $customerCount }}</p>
                </div>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.customers.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Detail →</a>
            </div>
        </div>
        
        <!-- Inquiry Card -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-green-100 to-green-200 text-green-600">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Permintaan</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $inquiryCount }}</p>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-xs font-medium bg-green-100 text-green-700 px-2 py-1 rounded-full">
                    {{ $inquiriesByStatus['new'] ?? 0 }} baru
                </span>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">Lihat Detail →</a>
            </div>
        </div>
        
        <!-- Project Card -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-purple-100 to-purple-200 text-purple-600">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Proyek</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $projectCount }}</p>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <span class="text-xs font-medium bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                    {{ $projectsByStatus['in_progress'] ?? 0 }} aktif
                </span>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Lihat Detail →</a>
            </div>
        </div>

        <!-- Message Card -->
        <div class="stat-card">
            <div class="flex items-center">
                <div class="stat-icon bg-gradient-to-br from-teal-100 to-teal-200 text-teal-600">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Pesan Belum Dibaca</h3>
                    @php
                        // Get unread message count for admin (messages + chats)
                        $unreadCount = \App\Models\Message::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        // Add unread chats from customers
                        $unreadChats = \App\Models\Chat::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        $unreadCount += $unreadChats;
                    @endphp
                    <p class="message-count text-2xl font-bold text-gray-800">{{ $unreadCount }}</p>
                </div>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.messages.index') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">Lihat Pesan →</a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Inquiries -->
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                <h4 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-inbox text-green-600 mr-3"></i>
                    Permintaan Terbaru
                </h4>
            </div>
            <div class="p-6">
                @if(count($recentInquiries) > 0)
                    <div class="space-y-4">
                        @foreach($recentInquiries as $inquiry)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="rounded-full bg-green-100 p-2">
                                        <i class="fas fa-envelope text-green-500"></i>
                                    </div>
                                </div>
                                <div class="ml-3 w-full">
                                    <div class="flex justify-between">
                                        <h5 class="text-sm font-medium text-gray-800">{{ $inquiry->name }} 
                                            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($inquiry->status === 'new') bg-green-100 text-green-800
                                            @elseif($inquiry->status === 'contacted') bg-blue-100 text-blue-800
                                            @elseif($inquiry->status === 'in_progress') bg-purple-100 text-purple-800
                                            @elseif($inquiry->status === 'completed') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                                {{ $inquiry->status }}
                                            </span>
                                        </h5>
                                        <span class="text-xs text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">{{ $inquiry->service->name }} - {{ $inquiry->description }}</p>
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-xs text-blue-500 hover:text-blue-700">Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada permintaan</p>
                @endif
            </div>
        </div>
        
        <!-- Ongoing Projects -->
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                <h4 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-project-diagram text-purple-600 mr-3"></i>
                    Proyek Sedang Berjalan
                </h4>
            </div>
            <div class="p-6">
                @if(count($ongoingProjects) > 0)
                    <div class="space-y-4">
                        @foreach($ongoingProjects as $project)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="rounded-full bg-purple-100 p-2">
                                        <i class="fas fa-tasks text-purple-500"></i>
                                    </div>
                                </div>
                                <div class="ml-3 w-full">
                                    <div class="flex justify-between">
                                        <h5 class="text-sm font-medium text-gray-800">{{ $project->name }}</h5>
                                        <span class="text-xs text-gray-500">{{ $project->start_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <span class="text-xs text-gray-500">Progress: {{ $project->progress_percentage }}%</span>
                                            <a href="{{ route('admin.projects.show', $project) }}" class="text-xs text-blue-500 hover:text-blue-700">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">Tidak ada proyek yang sedang berjalan</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card p-6">
        <h4 class="font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-3"></i>
            Aksi Cepat
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <a href="{{ route('admin.inquiries.create') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg flex items-center gap-4 transition-colors">
                <div class="bg-green-500 text-white p-3 rounded-lg">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h4 class="text-gray-800 font-medium">Tambah Permintaan</h4>
                    <p class="text-sm text-gray-500">Buat permintaan baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.projects.create') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg flex items-center gap-4 transition-colors">
                <div class="bg-purple-500 text-white p-3 rounded-lg">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <div>
                    <h4 class="text-gray-800 font-medium">Buat Proyek</h4>
                    <p class="text-sm text-gray-500">Tambah proyek baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.customers.index') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg flex items-center gap-4 transition-colors">
                <div class="bg-blue-500 text-white p-3 rounded-lg">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h4 class="text-gray-800 font-medium">Kelola Pelanggan</h4>
                    <p class="text-sm text-gray-500">Lihat daftar pelanggan</p>
                </div>
            </a>
            
            <a href="{{ route('admin.contracts.index') }}" class="bg-orange-50 hover:bg-orange-100 p-4 rounded-lg flex items-center gap-4 transition-colors">
                <div class="bg-orange-500 text-white p-3 rounded-lg">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div>
                    <h4 class="text-gray-800 font-medium">Kelola Kontrak</h4>
                    <p class="text-sm text-gray-500">Lihat semua kontrak</p>
                </div>
            </a>
            
            <a href="{{ route('admin.messages.index') }}" class="bg-teal-50 hover:bg-teal-100 p-4 rounded-lg flex items-center gap-4 transition-colors">
                <div class="bg-teal-500 text-white p-3 rounded-lg relative">
                    <i class="fas fa-comments"></i>
                    @php
                        // Get unread message count for admin (messages + chats)
                        $unreadCount = \App\Models\Message::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        // Add unread chats from customers
                        $unreadChats = \App\Models\Chat::where('is_from_admin', false)
                            ->where('is_read', false)
                            ->count();

                        $unreadCount += $unreadChats;
                    @endphp
                    @if($unreadCount > 0)
                        <span class="message-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $unreadCount }}
                        </span>
                    @else
                        <span class="message-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">
                            0
                        </span>
                    @endif
                </div>
                <div>
                    <h4 class="text-gray-800 font-medium">Chat Pelanggan</h4>
                    <p class="text-sm text-gray-500">Lihat pesan masuk</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto mark admin notifications as read when dashboard is opened
    markAdminNotificationsAsRead();

    function markAdminNotificationsAsRead() {
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
                console.log('Admin notifications marked as read');
                // Update notification badges
                if (typeof updateNotificationBadges === 'function') {
                    updateNotificationBadges();
                }
            }
        })
        .catch(error => {
            console.error('Error marking admin notifications as read:', error);
        });
    }
});
</script>
@endpush