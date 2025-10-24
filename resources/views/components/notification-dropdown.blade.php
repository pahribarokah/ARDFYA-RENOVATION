<!-- Simple Notification Badge -->
@auth
<div class="relative">
    <!-- Simple Bell with Badge -->
    <div class="relative p-2 text-gray-600 hover:text-green-600 transition-colors duration-200">
        <!-- Bell Icon -->
        <i class="fas fa-bell text-lg"></i>

        <!-- Red Badge - Fresh Count Every Time -->
        @php
            $freshCount = DB::table('notifications')
                ->where('notifiable_id', Auth::id())
                ->where('notifiable_type', 'App\\Models\\User')
                ->whereNull('read_at')
                ->count();
        @endphp

        @if($freshCount > 0)
        <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">
            {{ $freshCount > 99 ? '99+' : $freshCount }}
        </span>
        @else
        <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1" style="display: none;">
            0
        </span>
        @endif
    </div>
</div>
@endauth
