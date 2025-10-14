<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Modules\Setting\Settings\AboutSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutSetting extends SettingsPage
{
    use UseShield;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = AboutSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('About Setting');
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
                Section::make(__('About Us Setting'))
                    ->description(__('About Us Setting'))
                    ->schema([
                        RichEditor::make('about_us')
                            ->required()
                            ->label(__('About US'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("about_us")' : null),

                        TextInput::make('address')
                            ->required()
                            ->label(__('Address'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("address")' : null),

                    ]),
            ])->columns(1);
    }
}
