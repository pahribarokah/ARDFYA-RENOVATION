<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Real-time notification API endpoints
Route::middleware('auth')->group(function () {
    // Get notification counts for real-time updates
    Route::get('/notifications/count', function (Request $request) {
        $user = Auth::user();

        // Get unread notification count
        $notificationCount = $user->unreadNotifications()->count();

        // Get unread message count
        $messageCount = 0;
        if ($user->isAdmin()) {
            // For admin, count unread messages from customers (both messages and chats)
            $messageCount = Message::where('is_from_admin', false)
                ->where('is_read', false)
                ->count();

            // Add unread chats from customers
            $chatCount = \App\Models\Chat::where('is_from_admin', false)
                ->where('is_read', false)
                ->count();

            $messageCount += $chatCount;
        } else {
            // For customers, count unread messages from admin in messages table
            $messageCount = Message::where('is_from_admin', true)
                ->where('user_id', $user->id)
                ->where('is_read', false)
                ->count();

            // Add unread chats from admin
            $chatCount = \App\Models\Chat::where('is_from_admin', true)
                ->where('customer_id', $user->id)
                ->where('is_read', false)
                ->count();

            $messageCount += $chatCount;
        }

        return response()->json([
            'success' => true,
            'count' => $notificationCount,
            'messageCount' => $messageCount,
            'total' => $notificationCount + $messageCount
        ]);
    });
});

// API routes are currently not used in the frontend
// Uncomment below if API functionality is needed in the future

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for Services
Route::get('/services', function() {
    return \App\Models\Service::where('is_active', true)->get();
});

// API Routes for Inquiries
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/inquiries', function(Request $request) {
        $user = $request->user();
        if ($user->role === 'admin') {
            return \App\Models\Inquiry::with(['service', 'user'])->get();
        }
        return \App\Models\Inquiry::where('user_id', $user->id)->with('service')->get();
    });
});
*/