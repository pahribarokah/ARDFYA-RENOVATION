<?php

use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ReportsController as AdminReportsController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;


use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// API Routes for AJAX
Route::get('/api/services/all', [ServiceController::class, 'getAllServices'])->name('api.services.all');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{portfolio}', [HomeController::class, 'portfolioDetail'])->name('portfolio.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Service Routes (services.index removed - redirect to homepage #layanan)
Route::get('/services', function() {
    return redirect('/#layanan');
});
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Inquiry Routes
Route::get('/inquiries/create/{serviceId?}', [InquiryController::class, 'create'])->name('inquiries.create');
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
Route::get('/services/{service}/inquire', [InquiryController::class, 'inquire'])->name('services.inquire');

// Customer Inquiry Routes (Alternative Indonesian URL)
// Route::get('/layanan/permintaan', [InquiryController::class, 'create'])->name('inquiry.create');
// Route::post('/layanan/permintaan', [InquiryController::class, 'store'])->name('inquiry.store');


// Auth Routes
Auth::routes();



// Home Route (Redirect to appropriate dashboard)
Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
    return redirect()->route('home');
})->name('dashboard');

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Customer Chat Routes
    Route::get('/messages', [MessageController::class, 'customerChat'])->name('messages.customer');
    Route::get('/messages/get', [MessageController::class, 'getMessages'])->name('messages.get');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::post('/messages/read', [MessageController::class, 'markAsRead'])->name('messages.read');

    // Chat Routes
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send');
    Route::post('/chat/read', [ChatController::class, 'markAsRead'])->name('chat.read');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

    // Notification Settings Routes
    Route::get('/notification-settings', [NotificationSettingsController::class, 'index'])->name('customer.notification-settings');
    Route::put('/notification-settings', [NotificationSettingsController::class, 'update'])->name('customer.notification-settings.update');
    Route::get('/notification-settings/test', [NotificationSettingsController::class, 'test'])->name('customer.notification-settings.test');

    // Notification History Page
    Route::get('/notifications/all', function() {
        return view('customer.notifications');
    })->name('customer.notifications');

    // Test route
    Route::get('/test-notifications', function() {
        return view('test-notifications');
    });

    // Test notification creation
    Route::get('/create-test-notification', function() {
        if (Auth::check()) {
            $user = Auth::user();

            // Create a simple notification
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'App\\Notifications\\NewMessageNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'sender_name' => 'Test Admin',
                    'content' => 'This is a test notification created at ' . now(),
                    'context_type' => 'test',
                    'context_title' => 'Test Notification'
                ]),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Test notification created!');
        }

        return redirect('/login');
    });

    // Debug notifications
    Route::get('/debug-notifications', function() {
        if (Auth::check()) {
            $user = Auth::user();
            $total = $user->notifications()->count();
            $unread = $user->unreadNotifications()->count();
            $read = $user->readNotifications()->count();

            echo "<h2>Debug Notifications for User: {$user->name}</h2>";
            echo "<p>Total: {$total}</p>";
            echo "<p>Unread: {$unread}</p>";
            echo "<p>Read: {$read}</p>";
            echo "<hr>";

            foreach($user->notifications()->take(10)->get() as $n) {
                echo "<p>ID: {$n->id}<br>";
                echo "Type: {$n->type}<br>";
                echo "Read: " . ($n->read_at ? 'YES (' . $n->read_at . ')' : 'NO') . "<br>";
                echo "Created: {$n->created_at}<br>";
                echo "Data: " . $n->data . "</p><hr>";
            }
        } else {
            echo "Please login first";
        }
    });

    // Reset all notifications to unread
    Route::get('/reset-notifications', function() {
        if (Auth::check()) {
            $user = Auth::user();
            $user->notifications()->update(['read_at' => null]);
            return redirect()->back()->with('success', 'All notifications reset to unread!');
        }
        return redirect('/login');
    });

    // Clear all notifications
    Route::get('/clear-all-notifications', function() {
        if (Auth::check()) {
            $user = Auth::user();
            $user->notifications()->delete();
            return redirect()->back()->with('success', 'All notifications cleared!');
        }
        return redirect('/login');
    });
});

// Customer Dashboard Routes (Only for customers)
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Projects
    Route::get('/projects', [CustomerDashboardController::class, 'projects'])->name('projects');
    Route::get('/projects/{project}', [CustomerDashboardController::class, 'projectDetail'])->name('projects.detail');

    // Inquiries
    Route::get('/inquiries', [CustomerDashboardController::class, 'inquiries'])->name('inquiries');

    // Contracts
    Route::get('/contracts', [CustomerDashboardController::class, 'contracts'])->name('contracts');
    Route::get('/contracts/{contract}/download', [CustomerDashboardController::class, 'downloadContract'])->name('contracts.download');

    // Profile
    Route::get('/profile', [CustomerProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [CustomerProfileController::class, 'showChangePasswordForm'])->name('profile.password');
    Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Messages & Chat
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/stats', [AdminMessageController::class, 'getStats'])->name('messages.stats');
    Route::get('chat/customers', [ChatController::class, 'getCustomers'])->name('chat.customers');
    Route::get('chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('chat/all', [ChatController::class, 'getAllChats'])->name('chat.all'); 
    Route::post('chat/reply/{customerId}', [ChatController::class, 'adminReply'])->name('chat.reply');
    Route::post('chat/read', [ChatController::class, 'markAsRead'])->name('chat.read');
    
    // Admin API Routes
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/inquiries', [AdminMessageController::class, 'getInquiries'])->name('inquiries');
        Route::get('/projects', [AdminMessageController::class, 'getProjects'])->name('projects');
    });
    
    // Inquiries
    Route::resource('inquiries', AdminInquiryController::class);
    Route::post('inquiries/{inquiry}/update-status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');
    Route::post('inquiries/fix', [AdminInquiryController::class, 'fixOrphanedInquiries'])->name('inquiries.fix');
    
    // Projects 
    Route::resource('projects', AdminProjectController::class);
    
    // Customers
    Route::get('customers/json', [AdminCustomerController::class, 'getCustomersJson'])->name('customers.json');
    Route::resource('customers', AdminCustomerController::class);
    
    // Contracts
    Route::resource('contracts', AdminContractController::class);
    Route::get('contracts/{contract}/download', [AdminContractController::class, 'download'])->name('contracts.download');
    Route::get('contracts/{contract}/print', [AdminContractController::class, 'print'])->name('contracts.print');

    // Portfolios
    Route::resource('portfolios', AdminPortfolioController::class);

    // Services
    Route::resource('services', AdminServiceController::class);
    Route::post('services/{service}/toggle-status', [AdminServiceController::class, 'toggleStatus'])->name('services.toggleStatus');
    Route::post('services/{service}/toggle-featured', [AdminServiceController::class, 'toggleFeatured'])->name('services.toggleFeatured');
    Route::post('services/update-ordering', [AdminServiceController::class, 'updateOrdering'])->name('services.updateOrdering');
    Route::get('services/{service}/analytics', [AdminServiceController::class, 'analytics'])->name('services.analytics');

    // Analytics
    Route::get('analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/data', [AdminAnalyticsController::class, 'getData'])->name('analytics.data');

    // Reports
    Route::get('reports', [AdminReportsController::class, 'index'])->name('reports.index');
    Route::get('reports/customers', [AdminReportsController::class, 'customers'])->name('reports.customers');
    Route::get('reports/inquiries', [AdminReportsController::class, 'inquiries'])->name('reports.inquiries');
    Route::get('reports/projects', [AdminReportsController::class, 'projects'])->name('reports.projects');
    Route::get('reports/contracts', [AdminReportsController::class, 'contracts'])->name('reports.contracts');
    Route::get('reports/portfolios', [AdminReportsController::class, 'portfolios'])->name('reports.portfolios');
    Route::get('reports/{type}/export-pdf', [AdminReportsController::class, 'exportPdf'])->name('reports.exportPdf');
});


