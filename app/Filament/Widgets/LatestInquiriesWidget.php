<?php

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiriesWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Latest Inquiries';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Inquiry::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('hostel.title')->label('Hostel')->limit(25),
                TextColumn::make('name')->label('Inquirer'),
                TextColumn::make('mobile'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'danger',
                        'responded' => 'warning',
                        'closed' => 'success',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Date'),
            ]);
    }
}
