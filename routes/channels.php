<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{customerId}', function ($user, $customerId) {
    // Customers can only listen to their own chat channel
    return (int) $user->id === (int) $customerId;
});

Broadcast::channel('admin.chat', function ($user) {
    // Only admins can listen to the admin chat channel
    return $user->role === 'admin';
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    // Users can only listen to their own notification channel
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('admin.notifications', function ($user) {
    // Only admins can listen to admin notifications
    return $user->role === 'admin';
});