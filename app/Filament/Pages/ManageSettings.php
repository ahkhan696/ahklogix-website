<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static string|\UnitEnum|null  $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?int    $navigationSort  = 99;
    protected string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = ['whatsapp_number', 'booking_url', 'contact_email', 'chatbot_embed', 'linkedin_url', 'twitter_url', 'github_url'];
        $values = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        $this->form->fill($values);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contact & Booking')->schema([
                    TextInput::make('whatsapp_number')
                        ->label('WhatsApp number')
                        ->placeholder('971501234567')
                        ->helperText('International format, no + prefix. e.g. 971501234567'),
                    TextInput::make('booking_url')
                        ->label('Booking URL')
                        ->url()
                        ->placeholder('https://cal.com/ahklogix'),
                    TextInput::make('contact_email')
                        ->label('Contact email')
                        ->email(),
                ])->columns(2),

                Section::make('Social Links')->schema([
                    TextInput::make('linkedin_url')->label('LinkedIn')->url()->placeholder('https://linkedin.com/company/ahklogix'),
                    TextInput::make('twitter_url')->label('Twitter / X')->url()->placeholder('https://x.com/ahklogix'),
                    TextInput::make('github_url')->label('GitHub')->url()->placeholder('https://github.com/ahklogix'),
                ])->columns(3),

                Section::make('AI Chatbot')->schema([
                    Textarea::make('chatbot_embed')
                        ->label('Chatbot embed code')
                        ->rows(5)
                        ->helperText('Paste the full embed script from your chatbot provider. Leave empty to show the placeholder bubble.'),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save settings')
                ->action('save'),
        ];
    }
}
