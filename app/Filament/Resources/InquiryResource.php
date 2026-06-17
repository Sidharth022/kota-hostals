<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Models\Inquiry;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-envelope';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string { return 'Engagement'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'responded' => 'Responded',
                    'closed' => 'Closed',
                ])
                ->required(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            TextEntry::make('hostel.title')->label('Hostel'),
            TextEntry::make('name'),
            TextEntry::make('email'),
            TextEntry::make('mobile'),
            TextEntry::make('message')->columnSpanFull(),
            TextEntry::make('status')->badge()->color(fn ($state) => match ($state) {
                'pending' => 'danger',
                'responded' => 'warning',
                'closed' => 'success',
                default => 'secondary',
            }),
            TextEntry::make('created_at')->dateTime('d M Y H:i'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hostel.title')->label('Hostel')->searchable()->limit(30),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mobile'),
                TextColumn::make('status')->badge()->color(fn ($state) => match ($state) {
                    'pending' => 'danger',
                    'responded' => 'warning',
                    'closed' => 'success',
                    default => 'secondary',
                }),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'responded' => 'Responded',
                    'closed' => 'Closed',
                ]),
            ])
            ->actions([ViewAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInquiries::route('/'),
            'view' => Pages\ViewInquiry::route('/{record}'),
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
