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

    public function show(Request $request, $areaSlug, $slug)
    {
        $area = Area::where('slug', $areaSlug)->firstOrFail();
        
        $hostel = Hostel::where('slug', $slug)
            ->where('area_id', $area->id)
            ->where('status', 'active')
            ->with(['area', 'facilities', 'coachingCenters', 'reviews.user', 'images'])
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        // Unique View Tracking
        $ip = $request->ip();
        $userId = auth()->id();
        
        $alreadyViewed = \App\Models\HostelView::where('hostel_id', $hostel->id)
            ->where(function ($q) use ($ip, $userId) {
                $q->where('ip_address', $ip);
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            })
            ->where('viewed_at', '>=', now()->subHours(24))
            ->exists();

        if (!$alreadyViewed) {
            \App\Models\HostelView::create([
                'hostel_id' => $hostel->id,
                'user_id' => $userId,
                'ip_address' => $ip,
                'viewed_at' => now(),
            ]);

            // Safely increment views counter on hostels table
            $hostel->increment('views');
        }

        return view('hostels.show', compact('hostel'));
    }

    public function compare(Request $request)
    {
        $idsString = $request->query('ids', '');
        $hostelIds = array_filter(explode(',', $idsString), 'is_numeric');
        $hostelIds = array_slice($hostelIds, 0, 3); // max 3

        $hostels = [];
        if (count($hostelIds) > 0) {
            $hostels = Hostel::whereIn('id', $hostelIds)
                ->where('status', 'active')
                ->with(['area', 'facilities', 'images'])
                ->withAvg('reviews', 'rating')
                ->get();
        }

        return view('hostels.compare', compact('hostels'));
    }
}
