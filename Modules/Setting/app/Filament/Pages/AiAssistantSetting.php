<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Modules\Setting\Settings\AiAssistantSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AiAssistantSetting extends SettingsPage
{
    use UseShield;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = AiAssistantSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('Ai Assistant settings');
    }

    protected function getActions(): array
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        if ($tenant) {
            return [
                Action::make('back')->action(fn() => redirect()->route('filament.' . filament()->getCurrentPanel()->getId() . '.pages.settings-hub', $tenant))->color('danger')->label(trans('filament-settings-hub::messages.back')),
            ];
        }

        return [
            Action::make('back')->action(fn() => redirect()->route('filament.' . filament()->getCurrentPanel()->getId() . '.pages.settings-hub'))->color('danger')->label(trans('filament-settings-hub::messages.back')),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Prescription settings'))
                    ->description(__('Prescription settings'))
                    ->schema([

                        TextInput::make('ai_assistant_api_key')
                            ->required()
                            ->label(__('Api Key'))
                            ->columnSpan(1)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("ai_assistant_api_key")' : null),
                        
                        RichEditor::make('ai_assistant_prompt')
                            ->required()
                            ->label(__('Prompt'))
                            ->columnSpan(1)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("ai_assistant_prompt")' : null),

                    ]),
            ])->columns(1);
    }
}
