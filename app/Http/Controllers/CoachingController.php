<?php

namespace App\Http\Controllers;

use App\Models\CoachingCenter;
use Illuminate\Http\Request;

class CoachingController extends Controller
{
    public function show($slug)
    {
        $coaching = CoachingCenter::where('slug', $slug)->where('status', true)->firstOrFail();
        
        return redirect()->route('hostels.index', ['coaching' => $coaching->id]);
    }
}
