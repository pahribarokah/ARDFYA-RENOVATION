<?php

namespace App\Notifications;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InquiryStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Inquiry $inquiry;
    protected string $oldStatus;
    protected string $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Inquiry $inquiry, string $oldStatus, string $newStatus)
    {
        $this->inquiry = $inquiry;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check if user wants email notifications for inquiry status updates
        $notificationSettings = json_decode($notifiable->notification_settings, true) ?? [];
        if (!empty($notificationSettings['email_on_inquiry_status'])) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = [
            'pending' => 'Menunggu Review',
            'reviewed' => 'Sedang Direview',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai'
        ];

        $oldStatusLabel = $statusLabels[$this->oldStatus] ?? $this->oldStatus;
        $newStatusLabel = $statusLabels[$this->newStatus] ?? $this->newStatus;

        $subject = "Status inquiry Anda telah diperbarui - {$newStatusLabel}";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name}!")
            ->line("Status inquiry Anda untuk layanan {$this->inquiry->service->name} telah diperbarui.")
            ->line("Status sebelumnya: {$oldStatusLabel}")
            ->line("Status saat ini: {$newStatusLabel}")
            ->when($this->inquiry->admin_notes, function ($mail) {
                return $mail->line("Catatan admin: {$this->inquiry->admin_notes}");
            })
            ->action('Lihat Detail Inquiry', route('customer.inquiries'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'inquiry_id' => $this->inquiry->id,
            'service_name' => $this->inquiry->service->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'admin_notes' => $this->inquiry->admin_notes,
            'created_at' => now(),
        ];
    }
}
