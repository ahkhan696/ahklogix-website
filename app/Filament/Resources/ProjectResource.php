<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
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

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-briefcase';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Project Info')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) =>
                        $set('slug', Str::slug($state))
                    ),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('client'),
                Forms\Components\TextInput::make('category'),
                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add tag'),
                Forms\Components\TagsInput::make('stack')
                    ->placeholder('Add technology'),
            ])->columns(2),

            Section::make('Case Study')->schema([
                Forms\Components\Textarea::make('problem')->rows(3),
                Forms\Components\Textarea::make('solution')->rows(3),
                Forms\Components\RichEditor::make('results')->columnSpanFull(),
            ])->columns(2),

            Section::make('Images')->schema([
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->label('Cover image')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->label('Gallery (multiple images)')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->imagePreviewHeight('120')
                    ->maxFiles(12)
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
                SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->label('')
                    ->width(64)
                    ->height(48),
                Tables\Columns\TextColumn::make('order')->sortable()->width(60),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client')->searchable(),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\IconColumn::make('featured')->boolean(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('featured'),
                Tables\Filters\SelectFilter::make('category')
                    ->options(fn () => Project::distinct()->pluck('category', 'category')->filter()->toArray()),
            ])
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
