<?php

namespace Modules\Medicine\Filament\Resources\Medicines\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MedicineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
