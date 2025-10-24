<!DOCTYPE html>
<html>
<head>
    <title>Test Notifications</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Notifications</h1>
    
    @auth
        <h2>User: {{ Auth::user()->name }}</h2>
        <h3>Unread Count: {{ Auth::user()->unreadNotifications()->count() }}</h3>
        <h3>Total Notifications: {{ Auth::user()->notifications()->count() }}</h3>
        
        <h3>Notifications:</h3>
        @forelse(Auth::user()->notifications()->take(5)->get() as $notification)
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                <strong>ID:</strong> {{ $notification->id }}<br>
                <strong>Type:</strong> {{ $notification->type }}<br>
                <strong>Data:</strong> {{ json_encode($notification->data) }}<br>
                <strong>Read At:</strong> {{ $notification->read_at }}<br>
                <strong>Created:</strong> {{ $notification->created_at }}<br>
            </div>
        @empty
            <p>No notifications found</p>
        @endforelse
    @else
        <p>Please login first</p>
    @endauth
</body>
</html>
