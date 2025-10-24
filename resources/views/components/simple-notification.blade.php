<!-- Simple Notification Component -->
@auth
@php
    $unreadCount = Auth::user()->unreadNotifications()->count();
@endphp

<div class="relative">
    <!-- Bell Icon with Badge -->
    <div class="relative p-2 text-gray-600 hover:text-green-600 cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-3.5-3.5a8.38 8.38 0 010-11.8L20 2H9a8.38 8.38 0 00-5.95 2.55L2 6l1.05 1.05A8.38 8.38 0 005.5 13.5L2 17h5m8 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        
        <!-- Badge -->
        @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </span>
        @endif
    </div>
</div>
@endauth
