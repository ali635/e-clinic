<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Modules\Setting\Settings\NotificationBirthdaySettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;

class NotificationBirthdaySetting extends SettingsPage
{
    use UseShield;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = NotificationBirthdaySettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('Notification Birthday Setting');
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
                Section::make(__('Birthday Settings'))
                    ->description(__('Manage Birthday Notification Configration Settings'))
                    ->schema([
                        Tabs::make('Translations')
                            ->schema([
                                Tab::make('en')
                                    ->label(__('English'))
                                    ->schema([
                                        TextInput::make('birthday_title.en')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('birthday_description.en')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),

                                    ]),
                                Tab::make('ar')
                                    ->label(__('Arabic'))
                                    ->schema([
                                        TextInput::make('birthday_title.ar')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('birthday_description.ar')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Tab::make('ku')
                                    ->label(__('Kurdish'))
                                    ->schema([
                                        TextInput::make('birthday_title.ku')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('birthday_description.ku')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ]),
                    ]),
            ])->columns(1);
    }
}
