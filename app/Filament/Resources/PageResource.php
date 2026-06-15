<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationGroup(): ?string { return 'Content'; }

    public static function canViewAny(): bool
    {
        return auth()->user() && auth()->user()->isSuperAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Page Editor')->tabs([
                Tabs\Tab::make('Content')->schema([
                    TextInput::make('title')->required()->maxLength(191)->live(onBlur: true),
                    TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(191),
                    RichEditor::make('content')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('cms')
                        ->columnSpanFull(),
                    Toggle::make('status')->default(true)->label('Published'),
                ]),
                Tabs\Tab::make('SEO')->schema([
                    TextInput::make('seo_title')->maxLength(191)->helperText('60 chars recommended'),
                    Textarea::make('seo_description')->rows(3)->maxLength(320)->helperText('160 chars recommended'),
                    TextInput::make('og_image')->url()->maxLength(500)->label('OG Image URL'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->searchable(),
                ToggleColumn::make('status')->label('Published'),
                TextColumn::make('updated_at')->dateTime('d M Y')->sortable()->label('Last Updated'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('title');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
