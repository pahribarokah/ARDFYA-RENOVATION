@extends('layouts.customer')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Semua Notifikasi</h1>
            <p class="text-gray-600">Kelola dan lihat riwayat notifikasi Anda.</p>
        </div>
        
        <div class="flex space-x-3">
            @if(Auth::user()->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
                    </button>
                </form>
            @endif
            
            @if(Auth::user()->notifications()->count() > 0)
                <form action="{{ route('notifications.clear-all') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-trash mr-2"></i>Hapus Semua
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-bell text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Notifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->notifications()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Belum Dibaca</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->unreadNotifications()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sudah Dibaca</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->readNotifications()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900">Riwayat Notifikasi</h2>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse(Auth::user()->notifications()->paginate(20) as $notification)
                @php
                    $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                    $data = is_array($data) ? $data : [];
                @endphp
                
                <div class="p-6 hover:bg-gray-50 transition-colors duration-150 {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                    <div class="flex items-start space-x-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($notification->type === 'App\\Notifications\\NewMessageNotification') bg-blue-100 text-blue-600
                                @elseif($notification->type === 'App\\Notifications\\InquiryStatusNotification') bg-green-100 text-green-600
                                @elseif($notification->type === 'App\\Notifications\\ProjectUpdateNotification') bg-purple-100 text-purple-600
                                @elseif($notification->type === 'App\\Notifications\\TestNotification') bg-yellow-100 text-yellow-600
                                @else bg-gray-100 text-gray-600 @endif">
                                @if($notification->type === 'App\\Notifications\\NewMessageNotification')
                                    <i class="fas fa-comment"></i>
                                @elseif($notification->type === 'App\\Notifications\\InquiryStatusNotification')
                                    <i class="fas fa-clipboard-list"></i>
                                @elseif($notification->type === 'App\\Notifications\\ProjectUpdateNotification')
                                    <i class="fas fa-project-diagram"></i>
                                @elseif($notification->type === 'App\\Notifications\\TestNotification')
                                    <i class="fas fa-vial"></i>
                                @else
                                    <i class="fas fa-bell"></i>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900">
                                    @if($notification->type === 'App\\Notifications\\NewMessageNotification')
                                        Pesan baru dari {{ $data['sender_name'] ?? 'Admin' }}
                                    @elseif($notification->type === 'App\\Notifications\\InquiryStatusNotification')
                                        Status inquiry diperbarui
                                    @elseif($notification->type === 'App\\Notifications\\ProjectUpdateNotification')
                                        Update proyek
                                    @elseif($notification->type === 'App\\Notifications\\TestNotification')
                                        {{ $data['title'] ?? 'Test Notification' }}
                                    @else
                                        Notifikasi baru
                                    @endif
                                </h3>
                                
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Baru
                                        </span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <p class="mt-1 text-sm text-gray-600">
                                @if($notification->type === 'App\\Notifications\\NewMessageNotification')
                                    {{ Str::limit($data['content'] ?? '', 150) }}
                                @elseif($notification->type === 'App\\Notifications\\InquiryStatusNotification')
                                    Status berubah menjadi: {{ $data['new_status'] ?? '' }}
                                @elseif($notification->type === 'App\\Notifications\\ProjectUpdateNotification')
                                    {{ $data['project_title'] ?? '' }}
                                @elseif($notification->type === 'App\\Notifications\\TestNotification')
                                    {{ $data['message'] ?? 'Test notification' }}
                                @else
                                    Anda memiliki notifikasi baru
                                @endif
                            </p>
                            
                            <!-- Actions -->
                            <div class="mt-3 flex items-center space-x-3">
                                @if(!$notification->read_at)
                                    <button onclick="markNotificationAsRead('{{ $notification->id }}')"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <i class="fas fa-check mr-1"></i>Tandai Dibaca
                                    </button>
                                @endif
                                
                                <button onclick="deleteNotification('{{ $notification->id }}')"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada notifikasi</h3>
                    <p class="text-gray-600">Anda belum memiliki notifikasi apapun.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if(Auth::user()->notifications()->paginate(20)->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ Auth::user()->notifications()->paginate(20)->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto mark all notifications as read when notifications page is opened
    markAllNotificationsAsRead();
});

// Reuse functions from notification dropdown
function markNotificationAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function markAllNotificationsAsRead() {
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
            console.log('All notifications marked as read');
            // Update notification badges
            if (typeof updateCustomerNotificationBadges === 'function') {
                updateCustomerNotificationBadges();
            }
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

function deleteNotification(notificationId) {
    if (confirm('Hapus notifikasi ini?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
@endsection
