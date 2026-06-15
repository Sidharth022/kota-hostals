<?php

namespace App\Filament\Resources\HostelResource\RelationManagers;

use App\Models\Facility;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;

class FacilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'facilities';
    protected static ?string $recordTitleAttribute = 'title';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('id')
                ->label('Facility')
                ->options(Facility::pluck('title', 'id'))
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon'),
                TextColumn::make('title'),
            ])
            ->headerActions([AttachAction::make()->preloadRecordSelect()])
            ->actions([DetachAction::make()])
            ->bulkActions([BulkActionGroup::make([DetachBulkAction::make()])]);
    }
}
