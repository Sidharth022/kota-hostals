<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerAccountApprovedNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your KotaHostel Owner Account has been Approved!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We are pleased to inform you that your hostel owner account and profile have been reviewed and approved by the administrator.')
            ->line('You can now log in to your dashboard to list and manage your hostels.')
            ->action('Login to Dashboard', url('/login'))
            ->line('Thank you for partnering with KotaHostel!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Your hostel owner account has been approved by the administrator.',
            'status' => 'approved',
        ];
    }
}
