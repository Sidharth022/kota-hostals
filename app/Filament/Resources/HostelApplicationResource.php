<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostelApplicationResource\Pages;
use App\Models\HostelApplication;
use App\Models\Hostel;
use App\Models\User;
use App\Notifications\ApplicationStatusNotification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HostelApplicationResource extends Resource
{
    protected static ?string $model = HostelApplication::class;
    protected static ?string $navigationLabel = 'Hostel Applications';
    protected static ?string $pluralLabel = 'Hostel Applications';
    protected static ?string $slug = 'hostel-applications';
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string { return 'Listings'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('hostel_id')
                ->relationship('hostel', 'title')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('student_id')
                ->label('Student')
                ->options(User::whereHas('role', fn ($q) => $q->where('slug', 'student'))->pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

            DatePicker::make('joining_date')
                ->required(),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'cancelled' => 'Cancelled',
                ])
                ->required()
                ->default('pending'),

            Textarea::make('notes')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hostel.title')
                    ->label('Hostel')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.mobile')
                    ->label('Mobile'),

                TextColumn::make('joining_date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'cancelled' => 'gray',
                        default => 'light',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('hostel_id')
                    ->label('Hostel')
                    ->relationship('hostel', 'title'),

                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (HostelApplication $record) => $record->status === 'pending')
                    ->action(function (HostelApplication $record) {
                        $record->update(['status' => 'approved']);
                        $record->student->notify(new ApplicationStatusNotification($record));
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (HostelApplication $record) => $record->status === 'pending')
                    ->action(function (HostelApplication $record) {
                        $record->update(['status' => 'rejected']);
                        $record->student->notify(new ApplicationStatusNotification($record));
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHostelApplications::route('/'),
            'create' => Pages\CreateHostelApplication::route('/create'),
            'edit' => Pages\EditHostelApplication::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user() && auth()->user()->isOwner()) {
            return $query->whereHas('hostel', function ($q) {
                $q->where('owner_id', auth()->id());
            });
        }
        return $query;
    }
}
