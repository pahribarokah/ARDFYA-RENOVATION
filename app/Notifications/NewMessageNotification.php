<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Message $message;
    protected string $chatType;
    protected string $chatTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message, string $chatType, string $chatTitle)
    {
        $this->message = $message;
        $this->chatType = $chatType;
        $this->chatTitle = $chatTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check if user wants email notifications for new messages
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
        $url = route('messages.customer');
        
        // Customize based on chat type
        if ($this->chatType === 'inquiry') {
            $subject = "New message for your inquiry: {$this->chatTitle}";
        } else {
            $subject = "New message for your project: {$this->chatTitle}";
        }

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name}!")
            ->line('You have received a new message from ARDFYA.')
            ->line("Message: \"{$this->message->message}\"")
            ->action('View Message', $url)
            ->line('Thank you for using our services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user->name,
            'chat_type' => $this->chatType, // 'inquiry' or 'project'
            'chat_id' => $this->chatType === 'inquiry' ? $this->message->inquiry_id : $this->message->project_id,
            'chat_title' => $this->chatTitle,
            'content' => $this->message->message,
            'is_from_admin' => $this->message->is_from_admin,
            'created_at' => $this->message->created_at,
        ];
    }
}
