<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Modules\Setting\Settings\FooterSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FooterSocialSetting extends SettingsPage
{
    use UseShield;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = FooterSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('Footer Social settings');
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
                Section::make(__('Footer Social settings'))
                    ->description(__('Footer Social settings'))
                    ->schema([

                        TextInput::make('facebook_url')
                            ->required()
                            ->label(__('facebook Url'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("facebook_url")' : null),

                        TextInput::make('instagram_url')
                            ->required()
                            ->label(__('instagram Url'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("instagram_url")' : null),

                        TextInput::make('x_url')
                            ->required()
                            ->label(__('x Url'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("x_url")' : null),

                        TextInput::make('youtube_url')
                            ->required()
                            ->label(__('youtube Url'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("youtube_url")' : null),
                    ]),
            ])->columns(1);
    }
}
