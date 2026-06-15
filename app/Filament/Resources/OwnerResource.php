<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Models\User;
use App\Models\Role;
use App\Notifications\OwnerAccountApprovedNotification;
use App\Notifications\OwnerAccountRejectedNotification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;

class OwnerResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Hostel Owners';
    protected static ?string $pluralLabel = 'Hostel Owners';
    protected static ?string $slug = 'owners';
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string { return 'Users'; }

    public static function canViewAny(): bool
    {
        return auth()->user() && auth()->user()->isSuperAdmin();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('role', function ($query) {
            $query->where('slug', 'hostel-owner');
        });
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('User Account Details')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(191),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(191),

                    TextInput::make('mobile')
                        ->tel()
                        ->maxLength(15),

                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'suspended' => 'Suspended',
                            'banned' => 'Banned',
                        ])
                        ->required()
                        ->default('pending'),

                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create'),
                ])->columns(2),

            Section::make('Hostel Profile Details')
                ->relationship('ownerProfile')
                ->schema([
                    TextInput::make('hostel_name')
                        ->required()
                        ->maxLength(191),

                    TextInput::make('gst_number')
                        ->maxLength(191),

                    Textarea::make('address')
                        ->required()
                        ->rows(2)
                        ->columnSpanFull(),

                    TextInput::make('city')
                        ->required()
                        ->maxLength(191)
                        ->default('Kota'),

                    TextInput::make('state')
                        ->required()
                        ->maxLength(191)
                        ->default('Rajasthan'),

                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ])
                        ->required()
                        ->default('pending'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mobile')
                    ->searchable(),

                TextColumn::make('ownerProfile.hostel_name')
                    ->label('Hostel')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('User Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved', 'active' => 'success',
                        'pending' => 'warning',
                        'rejected', 'suspended', 'banned' => 'danger',
                        'inactive' => 'gray',
                        default => 'light',
                    }),

                TextColumn::make('ownerProfile.status')
                    ->label('Profile Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (User $record) => $record->status !== 'approved')
                    ->action(function (User $record) {
                        $record->update(['status' => 'approved']);
                        if ($record->ownerProfile) {
                            $record->ownerProfile->update(['status' => 'approved']);
                        }
                        
                        $record->notify(new OwnerAccountApprovedNotification());
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (User $record) => $record->status === 'pending')
                    ->form([
                        TextInput::make('reason')
                            ->label('Reason for Rejection')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->update(['status' => 'rejected']);
                        if ($record->ownerProfile) {
                            $record->ownerProfile->update(['status' => 'rejected']);
                        }
                        
                        $record->notify(new OwnerAccountRejectedNotification($data['reason']));
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
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
