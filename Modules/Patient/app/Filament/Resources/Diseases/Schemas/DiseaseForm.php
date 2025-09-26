<?php

namespace Modules\Patient\Filament\Resources\Diseases\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DiseaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->required(),
            ]);
    }
}
