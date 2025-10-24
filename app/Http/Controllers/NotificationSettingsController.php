<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationSettingsController extends Controller
{
    /**
     * Show notification settings page
     */
    public function index(): View
    {
        $user = Auth::user();
        $settings = json_decode($user->notification_settings, true) ?? [];
        
        // Default settings
        $defaultSettings = [
            'email_on_new_message' => true,
            'email_on_inquiry_status' => true,
            'email_on_project_update' => true,
            'browser_notifications' => true,
            'daily_summary' => false,
            'weekly_summary' => false,
        ];
        
        $settings = array_merge($defaultSettings, $settings);
        
        return view('customer.notification-settings', compact('settings'));
    }
    
    /**
     * Update notification settings
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_on_new_message' => 'boolean',
            'email_on_inquiry_status' => 'boolean',
            'email_on_project_update' => 'boolean',
            'browser_notifications' => 'boolean',
            'daily_summary' => 'boolean',
            'weekly_summary' => 'boolean',
        ]);
        
        $user = Auth::user();
        $user->notification_settings = json_encode($validated);
        $user->save();
        
        return redirect()->back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }
    
    /**
     * Test notification (for testing purposes)
     */
    public function test(): RedirectResponse
    {
        $user = Auth::user();
        
        // Create a test notification
        $user->notify(new \App\Notifications\TestNotification());
        
        return redirect()->back()->with('success', 'Notifikasi test telah dikirim!');
    }
}
