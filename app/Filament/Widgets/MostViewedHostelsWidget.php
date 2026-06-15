<?php

namespace App\Filament\Widgets;

use App\Models\Hostel;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MostViewedHostelsWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Most Viewed Hostels (Top 10)';
    protected ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $hostels = Hostel::select('title', 'views')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $hostels->pluck('views')->toArray(),
                    'backgroundColor' => array_fill(0, $hostels->count(), 'rgba(61, 95, 234, 0.7)'),
                    'borderColor' => array_fill(0, $hostels->count(), '#3D5FEA'),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $hostels->map(fn ($h) => \Illuminate\Support\Str::limit($h->title, 20))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
