<?php

namespace Modules\Room\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Room Information'))
                    ->description(__('Basic room details'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Room Name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('e.g., Room 1, Consultation Room')),

                        TextInput::make('code')
                            ->label(__('Room Code'))
                            ->maxLength(50)
                            ->placeholder(__('e.g., R1, CR01')),

                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'available' => __('Available'),
                                'unavailable' => __('Unavailable'),
                            ])
                            ->default('available')
                            ->required(),

                        Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3)
                            ->placeholder(__('Optional description of the room')),

                        Toggle::make('is_ready')
                            ->label(__('Is Ready'))
                            ->helperText(__('Indicates if the room is ready for the next patient'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
