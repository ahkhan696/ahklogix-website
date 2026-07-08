<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $modelLabel = 'FAQ';
    protected static ?string $pluralModelLabel = 'FAQs';
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-question-mark-circle';
    protected static string|\UnitEnum|null  $navigationGroup = 'Content';
    protected static ?int    $navigationSort  = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\Select::make('category')
                    ->options(['General' => 'General', 'Services' => 'Services', 'Process' => 'Process'])
                    ->required()
                    ->default('General'),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\Textarea::make('question')->required()->rows(2)->columnSpanFull(),
                Forms\Components\RichEditor::make('answer')->required()->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')->sortable()->width(60),
                Tables\Columns\TextColumn::make('category')->badge()->sortable(),
                Tables\Columns\TextColumn::make('question')->limit(70)->searchable()->wrap(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(['General' => 'General', 'Services' => 'Services', 'Process' => 'Process']),
            ])
            ->recordActions([Actions\EditAction::make()])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
