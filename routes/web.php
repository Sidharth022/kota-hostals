<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hostels', [HostelController::class, 'index'])->name('hostels.index');
Route::get('/hostels/{area}/{slug}', [HostelController::class, 'show'])->name('hostels.show');
Route::get('/area/{slug}', [AreaController::class, 'show'])->name('area.show');
Route::get('/coaching/{slug}', [CoachingController::class, 'show'])->name('coaching.show');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dynamic redirect landing page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student only routes
    Route::middleware('role:student')->group(function () {
        Route::get('/dashboard/favorites', [DashboardController::class, 'favorites'])->name('dashboard.favorites');
        Route::get('/dashboard/inquiries', [DashboardController::class, 'inquiries'])->name('dashboard.inquiries');
        Route::get('/dashboard/reviews', [DashboardController::class, 'reviews'])->name('dashboard.reviews');
        Route::get('/dashboard/applications', [DashboardController::class, 'applications'])->name('dashboard.applications');
    });

    // Owner only routes
    Route::middleware('role:hostel_owner')->group(function () {
        Route::get('/owner', [DashboardController::class, 'ownerIndex'])->name('owner.dashboard');
        Route::get('/owner/hostels', [DashboardController::class, 'ownerHostels'])->name('owner.hostels');
        Route::get('/owner/hostels/create', [DashboardController::class, 'ownerCreateHostel'])->name('owner.hostels.create');
        Route::post('/owner/hostels', [DashboardController::class, 'ownerStoreHostel'])->name('owner.hostels.store');
        Route::get('/owner/hostels/{hostel}/edit', [DashboardController::class, 'ownerEditHostel'])->name('owner.hostels.edit');
        Route::put('/owner/hostels/{hostel}', [DashboardController::class, 'ownerUpdateHostel'])->name('owner.hostels.update');
        Route::delete('/owner/hostels/{hostel}', [DashboardController::class, 'ownerDestroyHostel'])->name('owner.hostels.destroy');
        Route::get('/owner/inquiries', [DashboardController::class, 'ownerInquiries'])->name('owner.inquiries');
        Route::get('/owner/applications', [DashboardController::class, 'ownerApplications'])->name('owner.applications');
        Route::patch('/owner/applications/{application}/status', [DashboardController::class, 'updateApplicationStatus'])->name('owner.applications.status');
    });

    // Shared profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
