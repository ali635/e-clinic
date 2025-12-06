<?php

namespace Modules\Patient\Filament\Resources\Referrals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReferralForm
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
