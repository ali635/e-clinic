<?php

namespace Modules\Service\Filament\Resources\Services\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Modules\Service\Models\Service;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;

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
                    ->label(__('price'))
                    ->numeric()
                    ->required(),

                TimePicker::make('start')
                    ->label(__('start'))
                    ->required(),

                TimePicker::make('end')
                    ->label(__('end'))
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



                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),

                Toggle::make('is_home')
                    ->label(__('is home'))
                    ->required(),

                TextInput::make('order')
                    ->label(__('order'))
                    ->numeric()
                    ->required(),
            ]);
    }
}
