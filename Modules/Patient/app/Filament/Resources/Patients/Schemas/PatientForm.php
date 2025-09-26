<?php

namespace Modules\Patient\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->maxLength(255)
                    ->required(),

                TextInput::make('password')
                    ->label(__('password'))
                    ->password()
                    ->maxLength(255)
                    ->required(),

                TextInput::make('address')
                    ->label(__('address'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('gender')
                    ->label(__('gender'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('phone')
                    ->label(__('phone'))
                    ->maxLength(255)
                    ->required(),

                DatePicker::make('date_of_birth')
                    ->label(__('date_of_birth'))
                    ->required(),


            ]);
    }
}
