<?php

namespace Modules\User\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required(),

                TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->unique()
                    ->maxLength(255)
                    ->required(),

                TextInput::make('password')
                    ->label(__('password'))
                    ->password()
                    ->maxLength(255)
                    ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
