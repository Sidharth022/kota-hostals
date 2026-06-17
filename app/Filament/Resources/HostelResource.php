<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostelResource\Pages;
use App\Filament\Resources\HostelResource\RelationManagers;
use App\Models\Area;
use App\Models\Hostel;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class HostelResource extends Resource
{
    protected static ?string $model = Hostel::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationGroup(): ?string { return 'Listings'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Hostel Details')
                ->tabs([
                    // ── Tab 1: Basic Info ─────────────────────────────────
                    Tabs\Tab::make('Basic Info')->schema([
                        Select::make('owner_id')
                            ->label('Owner')
                            ->options(User::whereHas('role', fn ($query) => $query->where('slug', 'hostel-owner'))->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->default(fn () => auth()->id())
                            ->disabled(fn () => auth()->user() && auth()->user()->isOwner())
                            ->dehydrated(),

                        Select::make('area_id')
                            ->label('Area')
                            ->options(Area::pluck('title', 'id'))
                            ->searchable()
                            ->required(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(191)
                            ->live(onBlur: true),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(191),

                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('address')->required()->rows(2)->columnSpanFull(),

                        Select::make('gender_type')->options([
                                'boys' => 'Boys',
                                'girls' => 'Girls',
                                'coed' => 'Co-ed',
                            ])
                            ->required()
                            ->default('boys'),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('draft'),

                        Toggle::make('featured')->label('Featured'),
                        Toggle::make('verified')->label('Verified'),
                    ]),

                    // ── Tab 2: Pricing & Rooms ────────────────────────────
                    Tabs\Tab::make('Pricing & Rooms')->schema([
                        TextInput::make('monthly_rent')
                            ->numeric()
                            ->prefix('₹')
                            ->required()
                            ->default(0),

                        TextInput::make('security_deposit')
                            ->numeric()
                            ->prefix('₹')
                            ->nullable(),

                        CheckboxList::make('room_types')
                            ->options([
                                'single' => 'Single Room',
                                'double' => 'Double Room',
                                'triple' => 'Triple Room',
                            ])
                            ->columns(3),

                        TextInput::make('total_rooms')->numeric()->nullable(),
                        TextInput::make('available_rooms')->numeric()->nullable(),
                    ]),

                    // ── Tab 3: Location ──────────────────────────────────
                    Tabs\Tab::make('Location')->schema([
                        TextInput::make('latitude')
                            ->numeric()
                            ->step('0.00000001')
                            ->placeholder('e.g. 25.1496'),

                        TextInput::make('longitude')
                            ->numeric()
                            ->step('0.00000001')
                            ->placeholder('e.g. 75.8412'),

                        TextInput::make('google_map_url')
                            ->url()
                            ->maxLength(1000)
                            ->label('Google Map URL')
                            ->columnSpanFull(),
                    ]),

                    // ── Tab 3.5: Coaching Centers ─────────────────────────
                    Tabs\Tab::make('Coaching Centers')->schema([
                        \Filament\Forms\Components\Repeater::make('coaching_centers_repeater')
                            ->schema([
                                Select::make('coaching_center_id')
                                    ->label('Coaching Center')
                                    ->options(\App\Models\CoachingCenter::where('status', true)->pluck('title', 'id'))
                                    ->required()
                                    ->distinct(),
                                TextInput::make('distance_km')
                                    ->label('Distance (km)')
                                    ->numeric()
                                    ->step('0.01')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->label('Nearest Coaching Centers')
                            ->createItemButtonLabel('Add Coaching Center Connection')
                            ->afterStateHydrated(function ($component, $record) {
                                if (! $record) {
                                    return;
                                }
                                $state = $record->coachingCenters->map(fn ($item) => [
                                    'coaching_center_id' => $item->id,
                                    'distance_km' => $item->pivot->distance_km,
                                ])->toArray();
                                $component->state($state);
                            })
                            ->dehydrated(false),
                    ]),

                    // ── Tab 4: Gallery ───────────────────────────────────
                    Tabs\Tab::make('Gallery')->schema([
                        FileUpload::make('gallery_images')
                            ->label('Upload Images')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('hostels')
                            ->maxFiles(20)
                            ->columnSpanFull(),
                    ]),

                    // ── Tab 5: SEO ───────────────────────────────────────
                    Tabs\Tab::make('SEO')->schema([
                        TextInput::make('meta_title')
                            ->maxLength(191)
                            ->helperText('Leave blank to auto-generate')
                            ->columnSpanFull(),

                        Textarea::make('meta_description')
                            ->rows(3)
                            ->maxLength(320)
                            ->helperText('160 chars recommended')
                            ->columnSpanFull(),
                    ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                TextColumn::make('owner.name')
                    ->label('Owner')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('area.title')
                    ->label('Area')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('gender_type')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'boys' => 'info',
                        'girls' => 'pink',
                        'coed' => 'success',
                    }),

                TextColumn::make('monthly_rent')
                    ->money('INR')
                    ->sortable(),

                ToggleColumn::make('featured'),
                ToggleColumn::make('verified'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'active' => 'success',
                        'draft' => 'warning',
                        'inactive' => 'danger',
                    }),

                TextColumn::make('views')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('area')->relationship('area', 'title'),
                SelectFilter::make('gender_type')->options([
                    'boys' => 'Boys', 'girls' => 'Girls', 'coed' => 'Co-ed',
                ]),
                SelectFilter::make('status')->options([
                    'active' => 'Active', 'draft' => 'Draft', 'inactive' => 'Inactive',
                ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('verify_selected')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each->update(['verified' => true])),

                    BulkAction::make('feature_selected')
                        ->label('Feature Selected')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(fn (Collection $records) => $records->each->update(['featured' => true])),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelationManagers(): array
    {
        return [
            RelationManagers\FacilitiesRelationManager::class,
            RelationManagers\CoachingCentersRelationManager::class,
            RelationManagers\InquiriesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHostels::route('/'),
            'create' => Pages\CreateHostel::route('/create'),
            'edit' => Pages\EditHostel::route('/{record}/edit'),
            'view' => Pages\ViewHostel::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user() && auth()->user()->isOwner()) {
            return $query->where('owner_id', auth()->id());
        }
        return $query;
    }
}
