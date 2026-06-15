<?php

namespace App\Notifications;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInquiryNotification extends Notification
{
    use Queueable;

    protected $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Hostel Inquiry - ' . $this->inquiry->hostel->title)
            ->greeting('Hello!')
            ->line('You have received a new inquiry for your hostel ' . $this->inquiry->hostel->title)
            ->line('Student Name: ' . $this->inquiry->name)
            ->line('Message: "' . $this->inquiry->message . '"')
            ->action('View Inquiries', url('/owner/inquiries'))
            ->line('Thank you for using KotaHostel!');
    }

    public function toArray($notifiable): array
    {
        return [
            'inquiry_id' => $this->inquiry->id,
            'hostel_title' => $this->inquiry->hostel->title,
            'inquirer_name' => $this->inquiry->name,
            'message' => $this->inquiry->message,
        ];
    }
}
