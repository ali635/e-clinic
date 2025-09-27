<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RelatedServiceForm
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
            ]);
    }
}
