<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Modules\Setting\Settings\GeneralSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class GeneralSetting extends SettingsPage
{
    use UseShield;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = GeneralSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('General Setting');
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
                Section::make(__('General Setting'))
                    ->description(__('General Setting'))
                    ->schema([
                        Tabs::make('Translations')
                            ->schema([
                                Tab::make('en')
                                    ->label(__('English'))
                                    ->schema([
                                        TextInput::make('home_video.en')
                                            ->required()
                                            ->label(__('Home Video (English)'))
                                            ->columnSpan(2),

                                        FileUpload::make('hero_banner.en')
                                            ->required()
                                            ->disk('public')
                                            // ->directory('banners')
                                            ->label(__('Hero Banner (English)'))
                                            ->columnSpan(2),

                                        TextInput::make('banner_title.en')
                                            ->required()
                                            ->label(__('Banner Title (English)'))
                                            ->columnSpan(2),

                                        TextInput::make('banner_description.en')
                                            ->required()
                                            ->label(__('Banner Description (English)'))
                                            ->columnSpan(2),
                                    ]),
                                Tab::make('ar')
                                    ->label(__('Arabic'))
                                    ->schema([
                                        TextInput::make('home_video.ar')
                                            ->required()
                                            ->label(__('Home Video (Arabic)'))
                                            ->columnSpan(2),
                                        FileUpload::make('hero_banner.ar')
                                            ->required()
                                            ->disk('public')
                                            ->label(__('Hero Banner (Arabic)'))
                                            ->columnSpan(2),

                                        TextInput::make('banner_title.ar')
                                            ->required()
                                            ->label(__('Banner Title (Arabic)'))
                                            ->columnSpan(2),

                                        TextInput::make('banner_description.ar')
                                            ->required()
                                            ->label(__('Banner Description (Arabic)'))
                                            ->columnSpan(2),
                                    ]),

                                Tab::make('ku')
                                    ->label(__('Kurdish'))
                                    ->schema([
                                        TextInput::make('home_video.ku')
                                            ->required()
                                            ->label(__('Home Video (Kurdish)'))
                                            ->columnSpan(2),
                                        FileUpload::make('hero_banner.ku')
                                            ->required()
                                            ->disk('public')
                                            ->label(__('Hero Banner (Kurdish)'))
                                            ->columnSpan(2),
                                        TextInput::make('banner_title.ku')
                                            ->required()
                                            ->label(__('Banner Title (Kurdish)'))
                                            ->columnSpan(2),
                                        TextInput::make('banner_description.ku')
                                            ->required()
                                            ->label(__('Banner Description (Kurdish)'))
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ]),
            ])->columns(1);
    }
}
