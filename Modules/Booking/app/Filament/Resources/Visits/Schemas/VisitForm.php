<?php

namespace Modules\Booking\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\RelatedService;
use Modules\Service\Models\Service;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return
            $schema
            ->components([
                Grid::make()
                    ->gridContainer()
                    ->columns([
                        '@md' => 1,
                        '@xl' => 1,
                    ])->schema([
                        Section::make()
                            ->columns(3)
                            ->heading(__('General Information'))
                            ->schema([
                                Select::make('patient_id')
                                    ->label(__('patients'))
                                    ->relationship('patient', 'name')
                                    ->searchable()
                                    ->required(),

                                Select::make('service_id')
                                    ->label(__('services'))
                                    ->options(function () {
                                        return Service::with('translations')
                                            ->get()
                                            ->pluck('name', 'id')
                                            ->toArray();
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $service = Service::find($state);
                                            $set('price', $service ? $service->price : 0);
                                        } else {
                                            $set('price', 0);
                                        }
                                    })
                                    ->searchable()
                                    ->required(),

                                TextInput::make('price')
                                    ->label(__('Service price'))
                                    ->suffixIcon('heroicon-m-currency-dollar')
                                    ->disabled()
                                    ->default(0)
                                    ->numeric()
                                    ->reactive()
                                    ->dehydrated(true),
                            ]),

                        // Second section: Related service
                        Section::make()
                            ->columns(1) // Stack the repeater in a single column to align with the image
                            ->heading(__('Related service'))
                            ->schema([
                                Repeater::make('relatedService') // Renamed to plural to match relationship naming convention
                                    ->relationship() // Assumes a relationship like 'relatedServices' in the Visit model
                                    ->collapsible()
                                    ->addActionLabel(__('Add related service'))
                                    ->columns(3) // 3 columns for related_service_id, price_related_service, and qty
                                    ->schema([
                                        Select::make('related_service_id')
                                            ->label(__('related services'))
                                            ->options(function () {
                                                return RelatedService::with('translations')
                                                    ->get()
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            })
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                if ($state) {
                                                    $relatedService = RelatedService::find($state);
                                                    $price = $relatedService ? $relatedService->price : 0;
                                                    $qty = $get('qty') ?: 1; // Use current qty or default to 1
                                                    $set('price_related_service', $price * $qty);
                                                } else {
                                                    $set('price_related_service', 0);
                                                }
                                            })
                                            ->searchable()
                                            ->required(),

                                        TextInput::make('price_related_service')
                                            ->label(__('Related Service price'))
                                            ->suffixIcon('heroicon-m-currency-dollar')
                                            ->disabled()
                                            ->default(0)
                                            ->numeric()
                                            ->reactive()
                                            ->dehydrated(true),

                                        TextInput::make('qty')
                                            ->label(__('qty'))
                                            ->numeric()
                                            ->default(1) // Default to 1 instead of 0 for multiplication
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                if ($state) {
                                                    $relatedService = RelatedService::find($get('related_service_id'));
                                                    $price = $relatedService ? $relatedService->price : 0;
                                                    $set('price_related_service', $price * $state);
                                                } else {
                                                    $set('price_related_service', 0);
                                                }
                                            })
                                            ->required()
                                            ->dehydrated(true),
                                    ]),
                            ]),
                    ])
            ]);
    }
}
