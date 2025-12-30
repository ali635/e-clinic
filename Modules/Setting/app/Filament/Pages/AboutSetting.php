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
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
                        Tabs::make('Translations')
                            ->schema([
                                Tab::make('en')
                                    ->label(__('English'))
                                    ->schema([
                                        RichEditor::make('about_us.en')
                                            ->required()
                                            ->label(__('About Us (English)'))
                                            ->columnSpan(2),
                                        RichEditor::make('address.en')
                                            ->required()
                                            ->label(__('Address (English)'))
                                            ->columnSpan(2),
                                    ]),
                                Tab::make('ar')
                                    ->label(__('Arabic'))
                                    ->schema([
                                        RichEditor::make('about_us.ar')
                                            ->required()
                                            ->label(__('About Us (Arabic)'))
                                            ->columnSpan(2),
                                        RichEditor::make('address.ar')
                                            ->required()
                                            ->label(__('Address (Arabic)'))
                                            ->columnSpan(2),
                                    ]),

                                Tab::make('ku')
                                    ->label(__('Kurdish'))
                                    ->schema([
                                        RichEditor::make('about_us.ku')
                                            ->required()
                                            ->label(__('About Us (Kurdish)'))
                                            ->columnSpan(2),
                                        RichEditor::make('address.ku')
                                            ->required()
                                            ->label(__('Address (Kurdish)'))
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ]),
            ])->columns(1);
    }
}
