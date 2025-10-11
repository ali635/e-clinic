<?php

namespace Modules\Slider\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Slider\Settings\CounterSettings as SettingsCounterSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;

class CounterSettings extends SettingsPage
{
    use UseShield;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = SettingsCounterSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('counter settings');
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
                Section::make(__('counter settings'))
                    ->description(__('Counter Section in Home Page'))
                    ->schema([
                        Repeater::make('counter_settings')
                            ->required()
                            ->minItems(1)
                            ->columnSpan(2)
                            ->label(__('counter settings'))
                            ->schema([
                                TextInput::make('vendor')->label(__('key')),
                                TextInput::make('number_vendor')->label(__('value')),
                            ])
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("counter_settings")' : null),
                    ]),
            ])->columns(1);
    }
}
