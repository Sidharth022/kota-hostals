<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostelReportResource\Pages;
use App\Models\HostelReport;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HostelReportResource extends Resource
{
    protected static ?string $model = HostelReport::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string { return 'Listings'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('hostel_id')
                ->relationship('hostel', 'title')
                ->required()
                ->disabled(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->required()
                ->disabled(),
            TextInput::make('reason')
                ->required()
                ->disabled(),
            Textarea::make('description')
                ->disabled()
                ->columnSpanFull(),
            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved (Apply Penalty)',
                    'rejected' => 'Rejected',
                    'resolved' => 'Resolved',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hostel.title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Reported By')
                    ->searchable(),
                TextColumn::make('reason')
                    ->formatStateUsing(fn (string $state): string => HostelReport::$reasons[$state] ?? $state)
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'danger',
                        'rejected' => 'gray',
                        'resolved' => 'success',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'resolved' => 'Resolved',
                ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHostelReports::route('/'),
            'edit' => Pages\EditHostelReport::route('/{record}/edit'),
        ];
    }
}
