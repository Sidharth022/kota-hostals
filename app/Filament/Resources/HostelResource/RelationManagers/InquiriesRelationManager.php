<?php

namespace App\Filament\Resources\HostelResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class InquiriesRelationManager extends RelationManager
{
    protected static string $relationship = 'inquiries';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('mobile'),
                TextColumn::make('status')->badge()->color(fn ($state) => match ($state) {
                    'pending' => 'danger', 'responded' => 'warning', 'closed' => 'success', default => 'secondary',
                }),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->actions([DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
