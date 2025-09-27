<?php

namespace Modules\Service\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('price')
                    ->label(__('price'))
                    ->numeric()
                    ->required(),

               

                TimePicker::make('start')
                    ->label(__('start'))
                    ->required(),

                TimePicker::make('end')
                    ->label(__('end'))
                    ->required(),
                     TextInput::make('patient_time_minute')
                    ->label(__('patient time in minute'))
                    ->numeric()
                    ->required(),

                Textarea::make('short_description')
                    ->label(__('short description'))
                    ->required(),

                RichEditor::make('description')
                    ->label(__(' description'))
                    ->required(),

                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                TextInput::make('order')
                    ->label(__('order'))
                    ->numeric()
                    ->required(),
            ]);
    }
}
