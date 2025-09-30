<?php

namespace Modules\Location\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Modules\Location\Models\Country;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required(),
                Select::make('country_id')
                    ->label(__('countries'))
                    ->options(function () {
                        return Country::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
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
