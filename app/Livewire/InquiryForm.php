<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InquiryForm extends Component
{
    public $hostel_id;
    public $name = '';
    public $email = '';
    public $mobile = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'mobile' => 'required|string|regex:/^[0-9]{10}$/',
        'message' => 'required|string|max:500',
    ];

    protected $messages = [
        'mobile.regex' => 'Mobile number must be a valid 10-digit Indian mobile number.',
    ];

    public function mount($hostelId)
    {
        $this->hostel_id = $hostelId;

        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->mobile = $user->mobile ?? '';
        }
    }

    public function submit()
    {
        $this->validate();

        $inquiry = Inquiry::create([
            'student_id' => Auth::id(), // null if guest
            'hostel_id' => $this->hostel_id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'message' => $this->message,
            'status' => 'new',
        ]);

        // Trigger notification to hostel owner
        $hostel = $inquiry->hostel;
        if ($hostel && $hostel->owner) {
            try {
                $hostel->owner->notify(new \App\Notifications\NewInquiryNotification($inquiry));
            } catch (\Exception $e) {}
        }

        $this->reset(['message']);

        // Dispatch toast message event
        $this->dispatch('session-message', message: 'Inquiry sent successfully! The hostel owner will contact you soon.', type: 'success');
    }

    public function render()
    {
        return view('livewire.inquiry-form');
    }
}
