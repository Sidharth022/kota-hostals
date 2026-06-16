<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\HostelApplication;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // --- Student Dashboard ---

    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->intended('/admin');
        }

        if ($user->isOwner()) {
            return redirect()->intended('/owner');
        }

        return view('dashboard');
    }

    public function favorites()
    {
        $favorites = Auth::user()->favoriteHostels()->with(['area', 'images'])->get();
        return view('dashboard.favorites', compact('favorites'));
    }

    public function inquiries()
    {
        $inquiries = Auth::user()->inquiries()->with(['hostel.area'])->latest()->get();
        return view('dashboard.inquiries', compact('inquiries'));
    }

    public function reviews()
    {
        $reviews = Auth::user()->reviews()->with(['hostel.area'])->latest()->get();
        return view('dashboard.reviews', compact('reviews'));
    }

    public function applications()
    {
        $applications = Auth::user()->applications()->with(['hostel.area'])->latest()->get();
        return view('dashboard.applications', compact('applications'));
    }

    // --- Owner Dashboard ---

    public function ownerIndex()
    {
        $hostelIds = Auth::user()->hostels()->pluck('id');
        $totalHostels = $hostelIds->count();
        $totalInquiries = Inquiry::whereIn('hostel_id', $hostelIds)->count();
        $totalReviews = Review::whereIn('hostel_id', $hostelIds)->count();
        $totalViews = Auth::user()->hostels()->sum('views');
        $totalApplications = HostelApplication::whereIn('hostel_id', $hostelIds)->count();
        $favoriteCount = Favorite::whereIn('hostel_id', $hostelIds)->count();

        $recentInquiries = Inquiry::whereIn('hostel_id', $hostelIds)
            ->with(['hostel'])
            ->latest()
            ->limit(5)
            ->get();

        return view('owner.index', compact(
            'totalHostels',
            'totalInquiries',
            'totalReviews',
            'totalViews',
            'totalApplications',
            'favoriteCount',
            'recentInquiries'
        ));
    }

    public function ownerHostels()
    {
        $hostels = Auth::user()->hostels()->with(['area', 'images'])->latest()->get();
        return view('owner.hostels', compact('hostels'));
    }

    public function ownerCreateHostel()
    {
        $areas = Area::orderBy('title')->get();
        $facilities = Facility::orderBy('sort_order')->orderBy('title')->get();
        return view('owner.create-hostel', compact('areas', 'facilities'));
    }

    public function ownerStoreHostel(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'area_id' => 'required|exists:areas,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'gender_type' => 'required|in:boys,girls,coed',
            'status' => 'required|in:draft,active,inactive',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'room_types' => 'required|array|min:1',
            'room_types.*' => 'string|in:single,double,triple',
            'total_rooms' => 'nullable|integer|min:0',
            'available_rooms' => 'nullable|integer|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_map_url' => 'nullable|url|max:1000',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:320',
        ]);

        $request->validate([
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $data['owner_id'] = Auth::id();
        $data['featured'] = false;
        $data['verified'] = false;

        if ($request->hasFile('gallery_images')) {
            $paths = [];
            foreach ($request->file('gallery_images') as $image) {
                $paths[] = $image->store('hostels', 'public');
            }
            $data['gallery_images'] = $paths;
        }
        $hostel = Hostel::create($data);

        if ($request->has('facilities')) {
            $hostel->facilities()->sync($request->facilities);
        }

        return redirect()->route('owner.hostels')->with('status', 'Hostel created successfully.');
    }

    public function ownerEditHostel(Hostel $hostel)
    {
        if ($hostel->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $hostel->load('images');

        $areas = Area::orderBy('title')->get();
        $facilities = Facility::orderBy('sort_order')->orderBy('title')->get();
        return view('owner.edit-hostel', compact('hostel', 'areas', 'facilities'));
    }

    public function ownerUpdateHostel(Request $request, Hostel $hostel)
    {
        if ($hostel->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'area_id' => 'required|exists:areas,id',
            'description' => 'required|string',
            'address' => 'required|string',
            'gender_type' => 'required|in:boys,girls,coed',
            'status' => 'required|in:draft,active,inactive',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'room_types' => 'required|array|min:1',
            'room_types.*' => 'string|in:single,double,triple',
            'total_rooms' => 'nullable|integer|min:0',
            'available_rooms' => 'nullable|integer|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_map_url' => 'nullable|url|max:1000',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:320',
        ]);

        $request->validate([
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:hostel_images,id',
        ]);

        unset($data['gallery_images']);

        $hostel->update($data);

        $hostel->facilities()->sync($request->facilities ?? []);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = $hostel->images()->find($imageId);
                if ($img) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('gallery_images')) {
            $maxOrder = $hostel->images()->max('sort_order') ?? -1;
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('hostels', 'public');
                $hostel->images()->create([
                    'image_path' => $path,
                    'sort_order' => $maxOrder + 1 + $index,
                ]);
            }
        }

        return redirect()->route('owner.hostels')->with('status', 'Hostel updated successfully.');
    }

    public function ownerDestroyHostel(Hostel $hostel)
    {
        if ($hostel->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $hostel->delete();

        return redirect()->route('owner.hostels')->with('status', 'Hostel deleted successfully.');
    }

    public function ownerInquiries()
    {
        $hostelIds = Auth::user()->hostels()->pluck('id');
        $inquiries = Inquiry::whereIn('hostel_id', $hostelIds)
            ->with(['hostel'])
            ->latest()
            ->get();
        return view('owner.inquiries', compact('inquiries'));
    }

    public function ownerApplications()
    {
        $hostelIds = Auth::user()->hostels()->pluck('id');
        $applications = HostelApplication::whereIn('hostel_id', $hostelIds)
            ->with(['hostel', 'student'])
            ->latest()
            ->get();
        return view('owner.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, HostelApplication $application)
    {
        $hostel = $application->hostel;
        if ($hostel->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'status' => 'required|string|in:approved,rejected,cancelled',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        // Send notifications if applicable
        try {
            $application->student->notify(new \App\Notifications\ApplicationStatusNotification($application));
        } catch (\Exception $e) {}

        return redirect()->back()->with('status', 'Application status updated successfully.');
    }
}
