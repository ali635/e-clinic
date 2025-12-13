<?php

namespace Modules\Service\Filament\Resources\Services\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Service\Models\Service;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Service\Enums\DayOfWeek;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__(' name'))
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                        if ($operation !== 'create') {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label(__(' slug'))
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(Service::class, 'slug', ignoreRecord: true),

                TextInput::make('price')
                    ->label(__('Price'))
                    ->numeric()
                    ->required(),


                TextInput::make('patient_time_minute')
                    ->label(__('patient time in minute'))
                    ->numeric()
                    ->required(),

                Textarea::make('short_description')
                    ->label(__('short description'))
                    ->required(),

                RichEditor::make('description')
                    ->label(__(' description'))
                    ->required(),


                FileUpload::make('image')
                    ->label(__(' image'))
                    ->disk('public')
                    ->directory('service')
                    ->required(),


                TextInput::make('order')
                    ->label(__('order'))
                    ->numeric()
                    ->required(),
                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                Toggle::make('is_home')
                    ->label(__('is home'))
                    ->required(),



                Section::make(__('Available Time and Label Days'))
                    ->columns(1)
                    ->columnSpan(2)
                    ->schema([
                        Repeater::make('schedules')
                        ->label(__('schedules'))
                            ->relationship()
                            ->schema([
                                Select::make('day_of_week')
                                    ->label(__('day of week'))
                                    ->options(DayOfWeek::options())
                                    ->required(),
                                TimePicker::make('start_time')->label(__('start time'))->required(),
                                TimePicker::make('end_time')->label(__('end time'))->required(),
                                Toggle::make('is_active')->label(__('is active'))->default(true),
                            ])
                            ->columns(4)
                            ->collapsible(),
                    ])
            ]);
    }
}
