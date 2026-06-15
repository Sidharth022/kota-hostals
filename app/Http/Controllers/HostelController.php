<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index(Request $request)
    {
        return view('hostels.index');
    }

    public function show($areaSlug, $slug)
    {
        $area = Area::where('slug', $areaSlug)->firstOrFail();
        
        $hostel = Hostel::where('slug', $slug)
            ->where('area_id', $area->id)
            ->where('status', 'active')
            ->with(['area', 'facilities', 'coachingCenters', 'reviews.user'])
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        // Increment view count securely
        $hostel->increment('views');

        return view('hostels.show', compact('hostel'));
    }
}
