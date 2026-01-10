<?php

namespace Modules\Setting\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Kahusoftware\FilamentCkeditorField\CKEditor;
use Modules\Setting\Settings\FooterSettings;
use Modules\Setting\Settings\PrescriptionSettings;
use TomatoPHP\FilamentSettingsHub\Traits\UseShield;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PrescriptionSetting extends SettingsPage
{
    use UseShield;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = PrescriptionSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public function getTitle(): string
    {
        return __('Prescription settings');
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

                        CKEditor::make('prescription_name')
                            ->required()
                            ->label(__('Dr Name'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_name")' : null),

                        CKEditor::make('prescription_title')
                            ->required()
                            ->label(__('Title'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_title")' : null),

                        CKEditor::make('prescription_sub_title')
                            ->required()
                            ->label(__('Sub Title'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_sub_title")' : null),

                        TextInput::make('prescription_phone_one')
                            ->required()
                            ->label(__('Phone One'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_phone_one")' : null),

                        TextInput::make('prescription_phone_two')
                            ->required()
                            ->label(__('Phone two'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_phone_two")' : null),

                        TextInput::make('prescription_phone_three')
                            ->required()
                            ->label(__('Phone three'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_phone_three")' : null),

                        FileUpload::make('prescription_qr_code_one')
                            ->required()
                            ->disk('public')
                            ->label(__('Qr Code One'))
                            ->columnSpan(2),

                        FileUpload::make('prescription_qr_code_two')
                            ->required()
                            ->disk('public')
                            ->label(__('Qr Code Two'))
                            ->columnSpan(2),

                        FileUpload::make('prescription_logo')
                            ->required()
                            ->disk('public')
                            ->label(__('Background Logo'))
                            ->columnSpan(2),


                        TextInput::make('prescription_website')
                            ->required()
                            ->label(__('Website Link'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_website")' : null),


                        TextInput::make('prescription_social_title')
                            ->required()
                            ->label(__('Social Title'))
                            ->columnSpan(2)
                            ->hint(config('filament-settings-hub.show_hint') ? 'setting("prescription_social_title")' : null),




                    ]),
            ])->columns(1);
    }
}
