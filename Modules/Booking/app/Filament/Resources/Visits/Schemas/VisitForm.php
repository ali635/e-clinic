<?php

namespace Modules\Booking\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\RelatedService;
use Modules\Service\Models\Service;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // ===== General info (patient, service, price, total) =====
            Section::make(__('General Information'))
                ->columns(3)
                ->columnSpan(1)
                ->schema([
                    Select::make('patient_id')
                        ->label(__('patients'))
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->required()
                        ->columnSpan(1),

                    Select::make('service_id')
                        ->label(__('services'))
                        ->options(function () {
                            return Service::with('translations')
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            // update service price when selecting service
                            if ($state) {
                                $service = Service::find($state);
                                $set('price', $service ? $service->price : 0);
                            } else {
                                $set('price', 0);
                            }
                            // recalc total
                            $set('total_price', self::calculateTotal($get));
                        })
                        ->searchable()
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('price')
                        ->label(__('Service price'))
                        ->suffixIcon('heroicon-m-currency-dollar')
                        ->disabled()
                        ->default(0)
                        ->numeric()
                        ->reactive()
                        ->dehydrated(true)
                        ->helperText(__('This is the selected service base price'))
                        ->columnSpan(1),

                    TextInput::make('total_price')
                        ->label(__('Total price'))
                        ->suffixIcon('heroicon-m-currency-dollar')
                        ->disabled()
                        ->default(0)
                        ->numeric()
                        ->reactive()
                        ->dehydrated(true)
                        ->helperText(__('Auto-calculated: service price + related services'))
                        ->columnSpan(4),
                ]),

            Section::make(__('Arrival Information '))
                ->columns(1)
                ->columnSpan(1)
                ->schema([
                    DateTimePicker::make('arrival_time')
                        ->label(__('Arrival Time'))
                        ->helperText(__('Expected / actual arrival time')),

                    Toggle::make('is_arrival')
                        ->label(__('is arrival ?')),
                ]),
            // ===== Related services repeater =====
            Section::make(__('Related service'))
                ->columns(1)
                ->columnSpan(2)
                ->schema([
                    Repeater::make('relatedService')
                        ->table([
                            TableColumn::make('Related Service Name'),
                            TableColumn::make('Related Service price'),
                            TableColumn::make('QTY'),

                        ])
                        
                        ->relationship('relatedService')
                        ->collapsible()
                        ->addActionLabel(__('Add related service'))
                        ->columns(3)
                        ->reactive()
                        // when the overall repeater (items add/remove) changes, recalc total
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $set('total_price', self::calculateTotal($get));
                        })
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
                                    // set related service price * current qty
                                    $relatedService = $state ? RelatedService::find($state) : null;
                                    $price = $relatedService ? (float) $relatedService->price : 0;
                                    $qty = (int) ($get('qty') ?: 1);
                                    $set('price_related_service', $price * $qty);

                                    // recalc total (pass the parent $get)
                                    $set('total_price', self::calculateTotal($get));
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
                                ->default(0)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $relatedService = RelatedService::find($get('related_service_id'));
                                    $price = $relatedService ? (float) $relatedService->price : 0;
                                    $set('price_related_service', $price * ((int) ($state ?: 1)));

                                    // recalc total (pass the parent $get)
                                    $set('total_price', self::calculateTotal($get));
                                })
                                ->required(),
                        ]),
                ]),

            // ===== Attachments & notes (clean, grouped) =====
            Section::make(__('Attachments'))
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    FileUpload::make('lab_tests')
                        ->label(__('lab tests'))
                        ->multiple()
                        ->helperText(__('Drag & drop or browse to upload multiple lab tests')),

                    FileUpload::make('x-rays')
                        ->label(__('x-rays'))
                        ->multiple()
                        ->helperText(__('Drag & drop or browse to upload multiple x-rays')),
                ]),

            Section::make(__('Doctor & Treatment Notes'))
                ->columns(2)
                ->columnSpan(2)

                ->schema([
                    RichEditor::make('doctor_description')
                        ->label(__('Doctor Description'))
                        ->required()
                        ->helperText(__('Clinical notes and observations')),

                    RichEditor::make('treatment')
                        ->label(__('treatment Description'))
                        ->required()
                        ->helperText(__('Treatment plan and instructions')),
                ]),

            Section::make(__('Secretary & Patient'))
                ->columns(2)
                ->columnSpan(2)

                ->schema([
                    RichEditor::make('secretary_description')
                        ->label(__('secretary Description'))
                        ->helperText(__('Administrative notes, reminders')),



                    RichEditor::make('note')
                        ->label(__('Patient Description')),

                    FileUpload::make('attachment')
                        ->label(__('attachment'))
                        ->columnSpanFull()
                        ->helperText(__('Patient attachments')),

                ]),
        ]);
    }

    /**
     * Calculate total price using the form $get callable.
     *
     * $get will be the Filament callable that returns form state by path, e.g. $get('price') or $get('relatedService').
     *
     * @param callable $get
     * @return float
     */
    protected static function calculateTotal(callable $get): float
    {
        $servicePrice = (float) ($get('price') ?? 0);

        // relatedService is expected to be an array of items:
        $relatedItems = $get('relatedService') ?? [];
        $relatedTotal = 0.0;

        if (is_array($relatedItems)) {
            foreach ($relatedItems as $item) {
                // we prefer the computed per-item "price_related_service" (already qty * unitPrice)
                // fall back to 'price' if that's how your item is named.
                $relatedTotal += (float) ($item['price_related_service'] ?? $item['price'] ?? 0);
            }
        }

        return $servicePrice + $relatedTotal;
    }
}
