<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppResource\Pages;
use App\Models\App as AppModel;
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

class AppResource extends Resource
{
    protected static ?string $model = AppModel::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 5;
    protected static ?string $navigationLabel = 'Apps';

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
                    ->placeholder('calculator')
                    ->helperText('Heroicon name, e.g. heroicon-o-calculator'),
                Forms\Components\TextInput::make('tagline')
                    ->placeholder('One-line pitch for the tile card')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Tile image')->schema([
                SpatieMediaLibraryFileUpload::make('tile_image')
                    ->collection('tile_image')
                    ->label('Tile image (optional — shown on the /apps grid card)')
                    ->image()
                    ->imagePreviewHeight('160')
                    ->columnSpanFull(),
            ]),

            Section::make('Landing page')->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
            ]),

            Section::make('Features')->schema([
                Forms\Components\Repeater::make('feature_list')
                    ->label('Feature list (shown on landing page)')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->placeholder('e.g. Basic margin calculation'),
                        Forms\Components\Select::make('tier')
                            ->required()
                            ->options(['free' => 'Free', 'pro' => 'Pro'])
                            ->default('free'),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add feature')
                    ->collapsible()
                    ->columnSpanFull(),
            ]),

            Section::make('Display')->schema([
                Forms\Components\Select::make('status')
                    ->options(['live' => 'Live', 'coming_soon' => 'Coming soon'])
                    ->default('coming_soon')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('tile_image')
                    ->collection('tile_image')
                    ->label('')
                    ->width(48)
                    ->height(48),
                Tables\Columns\TextColumn::make('sort_order')->sortable()->width(60)->label('#'),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tagline')->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state === 'live' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Opens')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListApps::route('/'),
            'create' => Pages\CreateApp::route('/create'),
            'edit'   => Pages\EditApp::route('/{record}/edit'),
        ];
    }
}
