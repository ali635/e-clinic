<?php

namespace Modules\AdvancedLanguage\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lang_code')->label(__('lang code'))
                    ->options(LaravelLocalization::getSupportedLanguagesKeys())
                    ->searchable()
                    ->suffixIcon('heroicon-m-globe-alt'),
                TextInput::make('lang_flag')->label(__('lang flag'))
                    ->maxLength(255),
                TextInput::make('lang_name')->label(__('lang name'))
                    ->maxLength(255),

                Select::make('is_default')->label(__('is default'))
                    ->options([
                        1 => __('yes'),
                        0 => __('no'),
                    ]),
                Select::make('dir')->label(__('dir'))
                    ->options([
                        'rtl' => __('rtl'),
                        'ltr' => __('ltr'),
                    ]),
            ]);
    }
}
