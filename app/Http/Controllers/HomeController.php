<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CoachingCenter;
use App\Models\Hostel;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Popular Areas with active hostels count
        $popularAreas = Area::where('status', true)
            ->withCount(['hostels' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderByDesc('hostels_count')
            ->limit(6)
            ->get();

        // 2. Featured Hostels (with average rating and area details)
        $featuredHostels = Hostel::where('status', 'active')
            ->where('featured', true)
            ->with(['area', 'images'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->limit(6)
            ->get();

        // 3. Popular Coaching Centers
        $coachingCenters = CoachingCenter::where('status', true)
            ->withCount('hostels')
            ->orderByDesc('hostels_count')
            ->limit(4)
            ->get();

        // 4. Student Reviews/Testimonials
        $testimonials = Review::where('status', 'approved')
            ->where('rating', '>=', 4)
            ->with(['user', 'hostel'])
            ->latest()
            ->limit(4)
            ->get();

        $areas = Area::where('status', true)->orderBy('title')->get();
        $allCoachingCenters = CoachingCenter::where('status', true)->orderBy('title')->get();

        return view('welcome', compact('popularAreas', 'featuredHostels', 'coachingCenters', 'testimonials', 'areas', 'allCoachingCenters'));
    }
}
