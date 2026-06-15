<?php

namespace App\Livewire;

use App\Models\HostelApplication;
use App\Models\Hostel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HostelApplicationForm extends Component
{
    public $hostel_id;
    public $name = '';
    public $email = '';
    public $mobile = '';
    public $joining_date = '';
    public $notes = '';
    public $success_message = '';

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'mobile' => 'required|string|regex:/^[0-9]{10}$/',
        'joining_date' => 'required|date|after_or_equal:today',
        'notes' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'mobile.regex' => 'Mobile number must be a valid 10-digit mobile number.',
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'Please login to submit a hostel application.');
        }

        $this->validate();

        // Check if student has already applied to this hostel in pending state
        $existing = HostelApplication::where('hostel_id', $this->hostel_id)
            ->where('student_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            $this->dispatch('session-message', message: 'You have already submitted a pending application for this hostel.', type: 'warning');
            return;
        }

        $app = HostelApplication::create([
            'hostel_id' => $this->hostel_id,
            'student_id' => Auth::id(),
            'joining_date' => $this->joining_date,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        // Trigger notification to owner
        $hostel = $app->hostel;
        if ($hostel && $hostel->owner) {
            try {
                $hostel->owner->notify(new \App\Notifications\NewApplicationNotification($app));
            } catch (\Exception $e) {}
        }

        $this->reset(['joining_date', 'notes']);
        $this->success_message = 'Application submitted successfully! The owner will review it.';

        // Dispatch alert event
        $this->dispatch('session-message', message: 'Application submitted successfully! Check progress in your dashboard.', type: 'success');
        $this->dispatch('application-submitted');
    }

    public function render()
    {
        $hostel = Hostel::findOrFail($this->hostel_id);
        return view('livewire.hostel-application-form', compact('hostel'));
    }
}
