<?php

namespace App\Filament\Widgets;

use App\Models\Hostel;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $totalHostels = Hostel::count();
        $totalInquiries = Inquiry::count();
        $totalReviews = Review::count();

        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $newHostelsThisMonth = Hostel::whereMonth('created_at', now()->month)->count();
        $newInquiriesThisMonth = Inquiry::whereMonth('created_at', now()->month)->count();
        $pendingReviews = Review::where('status', 'pending')->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description("+{$newUsersThisMonth} this month")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-users'),

            Stat::make('Total Hostels', number_format($totalHostels))
                ->description("+{$newHostelsThisMonth} this month")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->icon('heroicon-o-building-office-2'),

            Stat::make('Total Inquiries', number_format($totalInquiries))
                ->description("+{$newInquiriesThisMonth} this month")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->icon('heroicon-o-envelope'),

            Stat::make('Pending Reviews', number_format($pendingReviews))
                ->description("{$totalReviews} total reviews")
                ->descriptionIcon('heroicon-m-star')
                ->color($pendingReviews > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-star'),
        ];
    }
}
