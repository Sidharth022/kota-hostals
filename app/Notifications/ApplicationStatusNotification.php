<?php

namespace App\Notifications;

use App\Models\HostelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct(HostelApplication $application)
    {
        $this->application = $application;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $statusText = ucfirst($this->application->status);

        return (new MailMessage)
            ->subject('Hostel Application ' . $statusText . ' - ' . $this->application->hostel->title)
            ->greeting('Hello!')
            ->line('The status of your application for ' . $this->application->hostel->title . ' has been updated.')
            ->line('New Status: ' . $statusText)
            ->action('View My Applications', url('/dashboard/applications'))
            ->line('Thank you for using KotaHostel!');
    }

    public function toArray($notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'hostel_title' => $this->application->hostel->title,
            'status' => $this->application->status,
        ];
    }
}
