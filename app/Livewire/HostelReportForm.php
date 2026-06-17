<?php

namespace App\Livewire;

use App\Models\HostelReport;
use Livewire\Component;

class HostelReportForm extends Component
{
    public $hostelId;
    public $reason = '';
    public $description = '';
    public $successMessage = '';

    protected $rules = [
        'reason' => 'required|string',
        'description' => 'required|string|min:10',
    ];

    public function mount($hostelId)
    {
        $this->hostelId = $hostelId;
    }

    public function submitReport()
    {
        if (!auth()->check()) {
            session()->flash('error', 'Please log in to submit a complaint.');
            return;
        }

        $this->validate();

        HostelReport::create([
            'hostel_id' => $this->hostelId,
            'user_id' => auth()->id(),
            'reason' => $this->reason,
            'description' => $this->description,
            'status' => 'pending',
        ]);

        $this->successMessage = 'Thank you. Your report has been submitted for review.';
        $this->reason = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.hostel-report-form');
    }
}
