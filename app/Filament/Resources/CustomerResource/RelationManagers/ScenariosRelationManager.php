<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ScenariosRelationManager extends RelationManager
{
    protected static string $relationship = 'calculatorScenarios';
    protected static ?string $title = 'Saved scenarios';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('products')
                    ->label('Products')
                    ->getStateUsing(fn ($record) => count($record->products))
                    ->suffix(' product(s)'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Saved')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
