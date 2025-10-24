<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Project $project;
    protected string $updateType;
    protected array $changes;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project, string $updateType, array $changes = [])
    {
        $this->project = $project;
        $this->updateType = $updateType;
        $this->changes = $changes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check if user wants email notifications for project updates
        $notificationSettings = json_decode($notifiable->notification_settings, true) ?? [];
        if (!empty($notificationSettings['email_on_project_update'])) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $updateTypeLabels = [
            'status_change' => 'Status proyek diperbarui',
            'progress_update' => 'Progress proyek diperbarui',
            'new_project' => 'Proyek baru dibuat',
            'project_completed' => 'Proyek telah selesai',
            'general_update' => 'Informasi proyek diperbarui'
        ];

        $subject = $updateTypeLabels[$this->updateType] ?? 'Update proyek';

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name}!")
            ->line("Ada update terbaru untuk proyek Anda: {$this->project->title}");

        // Add specific update information based on type
        switch ($this->updateType) {
            case 'status_change':
                if (isset($this->changes['status'])) {
                    $mail->line("Status proyek telah berubah menjadi: {$this->changes['status']}");
                }
                break;
            case 'progress_update':
                if (isset($this->changes['progress'])) {
                    $mail->line("Progress proyek saat ini: {$this->changes['progress']}%");
                }
                break;
            case 'new_project':
                $mail->line("Proyek baru telah dibuat berdasarkan inquiry Anda.");
                break;
            case 'project_completed':
                $mail->line("Selamat! Proyek Anda telah selesai dikerjakan.");
                break;
        }

        if (isset($this->changes['notes']) && !empty($this->changes['notes'])) {
            $mail->line("Catatan: {$this->changes['notes']}");
        }

        return $mail
            ->action('Lihat Detail Proyek', route('customer.projects.detail', $this->project))
            ->line('Terima kasih telah mempercayakan proyek Anda kepada kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'update_type' => $this->updateType,
            'changes' => $this->changes,
            'created_at' => now(),
        ];
    }
}
