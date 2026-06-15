<?php

namespace App\Livewire;

use App\Models\Area;
use App\Models\CoachingCenter;
use App\Models\Facility;
use App\Models\Hostel;
use Livewire\Component;
use Livewire\WithPagination;

class HostelSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search and Filters
    public $search = '';
    public $area = '';
    public $coaching = '';
    public $gender = '';
    public $room_type = '';
    public $min_price = null;
    public $max_price = null;
    public $selected_facilities = [];
    public $sort = 'latest';

    // Synchronize query parameters with URL
    protected $queryString = [
        'search' => ['except' => ''],
        'area' => ['except' => ''],
        'coaching' => ['except' => ''],
        'gender' => ['except' => ''],
        'room_type' => ['except' => ''],
        'min_price' => ['except' => null],
        'max_price' => ['except' => null],
        'selected_facilities' => ['except' => []],
        'sort' => ['except' => 'latest'],
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'area', 'coaching', 'gender', 'room_type', 'min_price', 'max_price', 'selected_facilities', 'sort']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Hostel::where('status', 'active')
            ->with(['area', 'facilities'])
            ->withAvg('reviews', 'rating');

        // Apply Search (title, description, address)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by Area Slug
        if ($this->area) {
            $query->whereHas('area', function ($q) {
                $q->where('slug', $this->area);
            });
        }

        // Filter by Coaching Center
        if ($this->coaching) {
            $query->whereHas('coachingCenters', function ($q) {
                $q->where('coaching_centers.id', $this->coaching);
            });
        }

        // Filter by Gender Type
        if ($this->gender) {
            $query->where('gender_type', $this->gender);
        }

        // Filter by Room Type
        if ($this->room_type) {
            $query->whereJsonContains('room_types', $this->room_type);
        }

        // Filter by Price Range
        if ($this->min_price !== null && $this->min_price !== '') {
            $query->where('monthly_rent', '>=', $this->min_price);
        }
        if ($this->max_price !== null && $this->max_price !== '') {
            $query->where('monthly_rent', '<=', $this->max_price);
        }

        // Filter by selected Facilities
        if (count($this->selected_facilities) > 0) {
            foreach ($this->selected_facilities as $facilityId) {
                $query->whereHas('facilities', function ($q) use ($facilityId) {
                    $q->where('facilities.id', $facilityId);
                });
            }
        }

        // Sorting
        switch ($this->sort) {
            case 'rent_asc':
                $query->orderBy('monthly_rent', 'asc');
                break;
            case 'rent_desc':
                $query->orderBy('monthly_rent', 'desc');
                break;
            case 'views_desc':
                $query->orderBy('views', 'desc');
                break;
            case 'rating_desc':
                $query->orderByDesc('reviews_avg_rating');
                break;
            default:
                $query->latest();
                break;
        }

        $hostels = $query->paginate(9);

        // Fetch filter options
        $areas = Area::where('status', true)->orderBy('sort_order')->get();
        $facilities = Facility::orderBy('sort_order')->get();
        $coachingCenters = CoachingCenter::where('status', true)->orderBy('title')->get();

        return view('livewire.hostel-search', compact('hostels', 'areas', 'facilities', 'coachingCenters'));
    }
}
