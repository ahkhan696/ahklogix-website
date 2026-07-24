<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatSessionResource\Pages;
use App\Models\ChatSession;
use Filament\Actions;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChatSessionResource extends Resource
{
    protected static ?string $model = ChatSession::class;
    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-chat-bubble-left-right';
    protected static string|\UnitEnum|null  $navigationGroup = 'Leads';
    protected static ?int    $navigationSort = 2;
    protected static ?string $navigationLabel = 'Chat Sessions';

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Session details')->schema([
                Infolists\Components\TextEntry::make('session_id')->label('Session ID')->copyable(),
                Infolists\Components\TextEntry::make('ip_address')->label('IP'),
                Infolists\Components\TextEntry::make('driver'),
                Infolists\Components\TextEntry::make('turns'),
                Infolists\Components\TextEntry::make('intent_detected')->label('Intent')->badge()
                    ->color(fn ($state) => match ($state) {
                        'whatsapp' => 'success',
                        'booking'  => 'info',
                        'contact'  => 'warning',
                        default    => 'gray',
                    }),
                Infolists\Components\IconEntry::make('handoff_triggered')->label('Handoff sent')->boolean(),
                Infolists\Components\TextEntry::make('created_at')->dateTime('d M Y, H:i'),
            ])->columns(2),

            Section::make('Conversation')->schema([
                Infolists\Components\RepeatableEntry::make('messages')->schema([
                    Infolists\Components\TextEntry::make('role')
                        ->badge()
                        ->color(fn ($state) => $state === 'user' ? 'info' : 'gray'),
                    Infolists\Components\TextEntry::make('content')->columnSpanFull(),
                ])->columns(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Started'),
                Tables\Columns\TextColumn::make('session_id')
                    ->formatStateUsing(fn ($state) => substr($state, 0, 8) . '…')
                    ->label('Session'),
                Tables\Columns\TextColumn::make('ip_address')->label('IP'),
                Tables\Columns\TextColumn::make('driver')
                    ->badge()
                    ->color(fn ($state) => str_contains($state, 'Rule') ? 'warning' : 'success'),
                Tables\Columns\TextColumn::make('turns'),
                Tables\Columns\TextColumn::make('intent_detected')
                    ->label('Intent')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'whatsapp' => 'success',
                        'booking'  => 'info',
                        'contact'  => 'warning',
                        default    => 'gray',
                    }),
                Tables\Columns\IconColumn::make('handoff_triggered')
                    ->label('Handoff')
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('driver')
                    ->options([
                        'GeminiDriver'     => 'Gemini',
                        'ClaudeDriver'     => 'Claude',
                        'RuleBasedDriver'  => 'Rule-based',
                    ]),
                Tables\Filters\TernaryFilter::make('handoff_triggered')->label('Handoff triggered'),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatSessions::route('/'),
            'view'  => Pages\ViewChatSession::route('/{record}'),
        ];
    }
}
