<?php

namespace App\Livewire;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public $hostel_id;
    public $is_favorite = false;

    public function mount($hostelId)
    {
        $this->hostel_id = $hostelId;

        if (Auth::check()) {
            $this->is_favorite = Favorite::where('user_id', Auth::id())
                ->where('hostel_id', $this->hostel_id)
                ->exists();
        }
    }

    public function toggle()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('hostel_id', $this->hostel_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $this->is_favorite = false;
            $this->dispatch('session-message', message: 'Hostel removed from saved list.', type: 'info');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'hostel_id' => $this->hostel_id,
            ]);
            $this->is_favorite = true;
            $this->dispatch('session-message', message: 'Hostel saved to your short-list!', type: 'success');
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
