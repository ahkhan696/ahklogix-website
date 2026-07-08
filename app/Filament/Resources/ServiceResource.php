<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) =>
                        $set('slug', Str::slug($state))
                    ),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('icon')
                    ->placeholder('heroicon-o-code-bracket')
                    ->helperText('Heroicon name used on cards, e.g. heroicon-o-code-bracket'),
                Forms\Components\Textarea::make('short_description')
                    ->required()
                    ->rows(2),
            ])->columns(2),

            Section::make('Service image')->schema([
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('icon_image')
                    ->label('Service image (optional — used on cards if uploaded)')
                    ->image()
                    ->imagePreviewHeight('160')
                    ->columnSpanFull(),
            ]),

            Section::make('Body')->schema([
                Forms\Components\RichEditor::make('body')
                    ->columnSpanFull(),
            ]),

            Section::make('Display & SEO')->schema([
                Forms\Components\Toggle::make('featured'),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\TextInput::make('seo_title'),
                Forms\Components\Textarea::make('seo_description')->rows(2),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('icon_image')
                    ->label('')
                    ->width(48)
                    ->height(48),
                Tables\Columns\TextColumn::make('order')->sortable()->width(60),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('short_description')->limit(60)->wrap(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('featured'),
            ])
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
