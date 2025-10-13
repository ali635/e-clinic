<?php

namespace Modules\Patient\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Modules\Location\Models\City;
use Modules\Location\Models\Country;
use Modules\Patient\Models\Disease;

use function Laravel\Prompts\select;

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
                    ->unique()
                    ->maxLength(255)
                    ->required(),

                TextInput::make('password')
                    ->label(__('password'))
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),



                Select::make('gender')
                    ->label(__('gender'))
                    ->options([
                        'male' => 'male',
                        'female' => 'female'
                    ])->required(),

                TextInput::make('phone')
                    ->label(__('phone'))
                    ->maxLength(255)
                    ->required(),

                DatePicker::make('date_of_birth')
                    ->label(__('date of birth'))
                    ->required(),
                Select::make('country_id')
                    ->label(__('countries'))
                    ->options(function () {
                        return Country::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Select::make('city_id')
                    ->label(__('cities'))
                    ->options(function () {
                        return City::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    }),
                TextInput::make('address')
                    ->label(__('address'))
                    ->maxLength(255)
                    ->required(),

                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                Select::make('disease_id')
                    ->label(__('diseases'))
                    ->options(function () {
                        return Disease::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record) {
                            $diseaseIds = $record->diseases->pluck('disease_id')->toArray();
                            $component->state($diseaseIds);
                        }
                    })
                    ->searchable()
                    ->multiple()
                    ->required(),

            ]);
    }
}
