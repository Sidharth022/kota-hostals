<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerAccountRejectedNotification extends Notification
{
    use Queueable;

    protected $reason;

    public function __construct(string $reason = '')
    {
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Update regarding your KotaHostel Owner Account')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We regret to inform you that your hostel owner registration could not be approved at this time.');

        if (!empty($this->reason)) {
            $mail->line('Reason for rejection: ' . $this->reason);
        }

        $mail->line('Please review your profile details or contact support for further assistance.')
             ->action('Contact Support', url('/contact'));

        return $mail;
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Your hostel owner account registration has been rejected.',
            'status' => 'rejected',
            'reason' => $this->reason,
        ];
    }
}
