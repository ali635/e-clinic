<?php

namespace Modules\Location\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
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
