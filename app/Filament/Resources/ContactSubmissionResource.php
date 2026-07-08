<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-inbox';
    protected static string|\UnitEnum|null  $navigationGroup = 'Leads';
    protected static ?int    $navigationSort  = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('company')->disabled(),
                Forms\Components\TextInput::make('service')->disabled(),
                Forms\Components\Select::make('status')
                    ->options(['new' => 'New', 'handled' => 'Handled'])
                    ->required(),
                Forms\Components\Textarea::make('message')->disabled()->rows(5)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('email')->copyable(),
                Infolists\Components\TextEntry::make('company'),
                Infolists\Components\TextEntry::make('service'),
                Infolists\Components\TextEntry::make('status')->badge()
                    ->color(fn ($state) => $state === 'new' ? 'warning' : 'success'),
                Infolists\Components\TextEntry::make('created_at')->dateTime('d M Y, H:i'),
                Infolists\Components\TextEntry::make('message')->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y, H:i')->sortable()->label('Received'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('service'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn ($state) => $state === 'new' ? 'warning' : 'success'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['new' => 'New', 'handled' => 'Handled']),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make()->label('Update status'),
            ])
            ->toolbarActions([Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListContactSubmissions::route('/'),
            'view'   => Pages\ViewContactSubmission::route('/{record}'),
            'edit'   => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
