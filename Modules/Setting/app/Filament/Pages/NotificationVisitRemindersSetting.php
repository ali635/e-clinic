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
use Modules\Setting\Settings\NotificationVisitRemindersSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;

class NotificationVisitRemindersSetting extends SettingsPage
{
    use UseShield;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = NotificationVisitRemindersSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('Notification Visit Reminders Setting');
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
                Section::make(__('Visit Reminders  Settings'))
                    ->description(__('Manage Visit Reminders Notification Configration Settings'))
                    ->schema([
                        Tabs::make('Translations')
                            ->schema([
                                Tab::make('en')
                                    ->label(__('English'))
                                    ->schema([
                                        TextInput::make('visit_reminder_title.en')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('visit_reminder_description.en')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),

                                    ]),
                                Tab::make('ar')
                                    ->label(__('Arabic'))
                                    ->schema([
                                        TextInput::make('visit_reminder_title.ar')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('visit_reminder_description.ar')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Tab::make('ku')
                                    ->label(__('Kurdish'))
                                    ->schema([
                                        TextInput::make('visit_reminder_title.ku')
                                            ->label(__('title'))
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('visit_reminder_description.ku')
                                            ->label(__('description'))
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ]),
                    ]),
            ])->columns(1);
    }
}
