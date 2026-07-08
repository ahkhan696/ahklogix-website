<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-star';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Reviewer')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('company'),
                Forms\Components\Select::make('rating')
                    ->options([1 => '1 Star', 2 => '2 Stars', 3 => '3 Stars', 4 => '4 Stars', 5 => '5 Stars'])
                    ->default(5)
                    ->required(),
                Forms\Components\Toggle::make('featured'),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
            ])->columns(2),

            Section::make('Photo')->schema([
                SpatieMediaLibraryFileUpload::make('photo')
                    ->collection('photo')
                    ->label('Reviewer photo (optional)')
                    ->image()
                    ->imagePreviewHeight('160')
                    ->columnSpanFull(),
            ]),

            Section::make('Quote')->schema([
                Forms\Components\Textarea::make('quote')->required()->rows(4)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('photo')
                    ->label('')
                    ->width(48)
                    ->height(48)
                    ->circular(),
                Tables\Columns\TextColumn::make('order')->sortable()->width(60),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('company')->searchable(),
                Tables\Columns\TextColumn::make('rating')->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 5 => 'success',
                        $state >= 4 => 'info',
                        default     => 'warning',
                    }),
                Tables\Columns\IconColumn::make('featured')->boolean(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('featured'),
                Tables\Filters\SelectFilter::make('rating')
                    ->options([5 => '5 Stars', 4 => '4 Stars', 3 => '3 Stars']),
            ])
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit'   => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
