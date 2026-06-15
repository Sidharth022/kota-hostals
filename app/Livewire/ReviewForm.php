<?php

namespace App\Livewire;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewForm extends Component
{
    public $hostel_id;
    public $rating = 5;
    public $review = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|min:10|max:1000',
    ];

    public function mount($hostelId)
    {
        $this->hostel_id = $hostelId;
    }

    public function setRating($value)
    {
        $this->rating = (int) $value;
    }

    public function submit()
    {
        if (! Auth::check()) {
            return $this->dispatch('session-message', message: 'You must be logged in to leave a review.', type: 'error');
        }

        $this->validate();

        // Check if user has already reviewed this hostel
        $exists = Review::where('user_id', Auth::id())
            ->where('hostel_id', $this->hostel_id)
            ->exists();

        if ($exists) {
            return $this->dispatch('session-message', message: 'You have already submitted a review for this hostel.', type: 'error');
        }

        Review::create([
            'user_id' => Auth::id(),
            'hostel_id' => $this->hostel_id,
            'rating' => $this->rating,
            'review' => $this->review,
            'status' => 'pending', // Requires admin approval
        ]);

        $this->reset(['review', 'rating']);

        $this->dispatch('session-message', message: 'Thank you! Your review has been submitted for moderation.', type: 'success');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
