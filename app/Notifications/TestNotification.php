<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check if user wants email notifications
        $notificationSettings = json_decode($notifiable->notification_settings, true) ?? [];
        if (!empty($notificationSettings['email_on_new_message'])) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Test Notification - ARDFYA')
            ->greeting("Hello {$notifiable->name}!")
            ->line('This is a test notification to verify that your notification settings are working correctly.')
            ->line('You are receiving this because you have email notifications enabled.')
            ->action('Visit Dashboard', route('customer.dashboard'))
            ->line('Thank you for using ARDFYA!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Test Notification',
            'message' => 'This is a test notification to verify your notification settings.',
            'type' => 'test',
            'created_at' => now(),
        ];
    }
}
