<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Modules\Setting\Settings\CounterSettings as SettingsCounterSettings;
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
                Section::make(__('Counter Settings'))
                    ->description(__('Manage counters displayed on the home page'))
                    ->schema([
                        Tabs::make('Translations')
                            ->schema([
                                 Tab::make('en')
                                    ->label(__('English'))
                                    ->schema([
                                        Repeater::make('counter_settings.en')
                                            ->required()
                                            ->minItems(1)
                                            ->columnSpan(2)
                                            ->label(__('Counter Settings (English)'))
                                            ->schema([
                                                TextInput::make('vendor')
                                                    ->label(__('Key'))
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('number_vendor')
                                                    ->label(__('Value'))
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                                Tab::make('ar')
                                    ->label(__('Arabic'))
                                    ->schema([
                                        Repeater::make('counter_settings.ar')
                                            ->required()
                                            ->minItems(1)
                                            ->columnSpan(2)
                                            ->label(__('Counter Settings (Arabic)'))
                                            ->schema([
                                                TextInput::make('vendor')
                                                    ->label(__('Key'))
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('number_vendor')
                                                    ->label(__('Value'))
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                               Tab::make('ku')
                                    ->label(__('Kurdish'))
                                    ->schema([
                                        Repeater::make('counter_settings.ku')
                                            ->required()
                                            ->minItems(1)
                                            ->columnSpan(2)
                                            ->label(__('Counter Settings (Kurdish)'))
                                            ->schema([
                                                TextInput::make('vendor')
                                                    ->label(__('Key'))
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('number_vendor')
                                                    ->label(__('Value'))
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                                ]),
                    ]),
            ])->columns(1);
    }
}
