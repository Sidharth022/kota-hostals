<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function show($slug)
    {
        $area = Area::where('slug', $slug)->where('status', true)->firstOrFail();
        
        return redirect()->route('hostels.index', ['area' => $slug]);
    }
}
