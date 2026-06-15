<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachingCenterResource\Pages;
use App\Models\CoachingCenter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CoachingCenterResource extends Resource
{
    protected static ?string $model = CoachingCenter::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationGroup(): ?string { return 'Settings'; }

    public static function canViewAny(): bool
    {
        return auth()->user() && auth()->user()->isSuperAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title')->required()->maxLength(191),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(191),
            TextInput::make('address')->maxLength(500),
            TextInput::make('latitude')->numeric()->step('0.00000001'),
            TextInput::make('longitude')->numeric()->step('0.00000001'),
            TextInput::make('logo')->maxLength(500)->helperText('Image URL or path'),
            TextInput::make('website')->url()->maxLength(500),
            Toggle::make('status')->default(true)->label('Active'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address')->limit(40)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('hostels_count')->counts('hostels')->label('Hostels')->badge()->color('primary'),
                ToggleColumn::make('status'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('title');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoachingCenters::route('/'),
            'create' => Pages\CreateCoachingCenter::route('/create'),
            'edit' => Pages\EditCoachingCenter::route('/{record}/edit'),
        ];
    }
}
