<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-document-text';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Post Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) =>
                        $set('slug', Str::slug($state))
                    ),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('author')->default('AHKLOGIX Team'),
                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published'])
                    ->default('draft')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\TagsInput::make('tags')->placeholder('Add tag'),
            ])->columns(2),

            Section::make('Cover image')->schema([
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->label('Cover image')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->columnSpanFull(),
            ]),

            Section::make('Content')->schema([
                Forms\Components\Textarea::make('excerpt')->rows(2)->columnSpanFull(),
                Forms\Components\RichEditor::make('body')->columnSpanFull(),
            ]),

            Section::make('SEO')->schema([
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
                    ->width(80)
                    ->height(48),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('author'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn ($state) => $state === 'published' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('published_at')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published']),
            ])
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
