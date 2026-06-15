<?php

namespace App\Notifications;

use App\Models\HostelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
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
        return (new MailMessage)
            ->subject('New Hostel Application - ' . $this->application->hostel->title)
            ->greeting('Hello!')
            ->line('A student has applied for admission into your hostel: ' . $this->application->hostel->title)
            ->line('Student Name: ' . $this->application->student->name)
            ->line('Preferred Joining Date: ' . $this->application->joining_date->format('d M Y'))
            ->action('View Applications', url('/owner/applications'))
            ->line('Thank you for using KotaHostel!');
    }

    public function toArray($notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'hostel_title' => $this->application->hostel->title,
            'student_name' => $this->application->student->name,
            'joining_date' => $this->application->joining_date->format('Y-m-d'),
        ];
    }
}
