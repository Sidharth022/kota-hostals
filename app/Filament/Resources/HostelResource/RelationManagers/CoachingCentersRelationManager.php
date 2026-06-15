<?php

namespace App\Filament\Resources\HostelResource\RelationManagers;

use App\Models\CoachingCenter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;

class CoachingCentersRelationManager extends RelationManager
{
    protected static string $relationship = 'coachingCenters';
    protected static ?string $recordTitleAttribute = 'title';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('distance_km')
                ->label('Distance (km)')
                ->numeric()
                ->step('0.01'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('pivot.distance_km')->label('Distance (km)')->badge()->color('info'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('distance_km')->numeric()->step('0.01')->label('Distance (km)'),
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->bulkActions([BulkActionGroup::make([DetachBulkAction::make()])]);
    }
}
