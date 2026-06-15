<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->active()->firstOrFail();

        // If contact page, render specific view if available, or fallback
        if ($slug === 'contact') {
            return view('pages.contact', compact('page'));
        }

        return view('pages.show', compact('page'));
    }
}
