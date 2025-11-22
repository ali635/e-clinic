<?php

namespace Modules\Booking\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                    // Patient select
                    Select::make('patient_id')
                        ->label(__('patients'))
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->required()
                        ->columnSpan(1),

                    // Service select
                    Select::make('service_id')
                        ->label(__('services'))
                        ->options(function () {
                            return Service::with('translations')
                                ->get()
                                ->mapWithKeys(function ($service) {
                                    // Fallback for null name
                                    return [$service->id => $service->name ?? __('Unnamed Service')];
                                })
                                ->toArray();
                        })
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            // update service price when selecting service
                            $service = $state ? Service::find($state) : null;
                            $set('price', $service?->price ?? 0);
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

            // ===== Arrival info =====
            Section::make(__('Arrival Information'))
                ->columns(1)
                ->columnSpan(1)
                ->schema([
                    DateTimePicker::make('arrival_time')
                        ->label(__('Arrival Time'))
                        ->helperText(__('Expected / actual arrival time')),

                    Select::make('status')
                        ->label(__('Status'))
                        ->options([
                            'pending' => __('Pending'),
                            'complete' => __('Complete'),
                            'cancelled' => __('Cancelled'),
                        ])
                        ->default('pending')
                        ->required(),

                    Toggle::make('is_arrival')
                        ->label(__('Is arrival?')),
                ]),

            // ===== Related services repeater =====
            Section::make(__('Related Services'))
                ->columns(1)
                ->columnSpan(2)
                ->schema([
                    Repeater::make('relatedService')
                        ->relationship('relatedService')
                        ->collapsible()
                        ->addActionLabel(__('Add related service'))
                        ->columns(3)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $set('total_price', self::calculateTotal($get));
                        })
                        ->schema([
                            Select::make('related_service_id')
                                ->label(__('Related services'))
                                ->options(function () {
                                    return RelatedService::with('translations')
                                        ->get()
                                        ->mapWithKeys(function ($relatedService) {
                                            return [$relatedService->id => $relatedService->name ?? __('Unnamed Related Service')];
                                        })
                                        ->toArray();
                                })
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $relatedService = $state ? RelatedService::find($state) : null;
                                    $unitPrice = (float) ($relatedService?->price ?? 0);

                                    // store unit price (not multiplied)
                                    $set('price_related_service', $unitPrice);

                                    // recompute total for whole form
                                    $set('total_price', self::calculateTotal($get));
                                })
                                ->searchable()
                                ->required(),

                            TextInput::make('price_related_service')
                                ->label(__('Related Service Price'))
                                ->suffixIcon('heroicon-m-currency-dollar')
                                ->disabled()
                                ->default(0)
                                ->numeric()
                                ->reactive()
                                ->dehydrated(true),

                            TextInput::make('qty')
                                ->label(__('Quantity'))
                                ->numeric()
                                ->default(0)                // <-- change from 0 to 1
                                ->reactive()
                                ->dehydrated(true)
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $relatedService = RelatedService::find($get('related_service_id'));
                                    $unitPrice = (float) ($relatedService?->price ?? 0);
                                    // store unit price (not multiplied)
                                    $set('price_related_service', $unitPrice);
                                    $set('total_price', self::calculateTotal($get));
                                })
                                ->required(),
                        ]),
                ]),

            // ===== Attachments =====
            Section::make(__('Attachments'))
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    FileUpload::make('lab_tests')
                        ->label(__('Lab tests'))
                        ->disk('public')
                        ->directory('visit')
                        ->multiple()
                        ->helperText(__('Drag & drop or browse to upload multiple lab tests')),

                    FileUpload::make('x_rays')
                        ->label(__('X-rays'))
                        ->disk('public')
                        ->directory('visit')
                        ->multiple()
                        ->helperText(__('Drag & drop or browse to upload multiple x-rays')),
                ]),

            // ===== Doctor & Treatment Notes =====
            Section::make(__('Doctor & Treatment Notes'))
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    RichEditor::make('doctor_description')
                        ->label(__('Doctor Description'))
                        ->required()
                        ->helperText(__('Clinical notes and observations')),

                    RichEditor::make('treatment')
                        ->label(__('Treatment Description'))
                        ->required()
                        ->helperText(__('Treatment plan and instructions')),
                ]),

            // ===== Secretary & Patient Notes =====
            Section::make(__('Secretary & Patient'))
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    RichEditor::make('secretary_description')
                        ->label(__('Secretary Description'))
                        ->helperText(__('Administrative notes, reminders')),

                    RichEditor::make('note')
                        ->label(__('Patient Notes')),

                    FileUpload::make('attachment')
                        ->label(__('Attachment'))
                        ->disk('public')
                        ->directory('visit')
                        ->columnSpanFull()
                        ->helperText(__('Patient attachments')),
                ]),
        ]);
    }

    /**
     * Calculate total price using the form $get callable.
     */
    protected static function calculateTotal(callable $get): float
    {
        $servicePrice = (float) ($get('price') ?? 0);
        $relatedItems = $get('relatedService') ?? [];
        $relatedTotal = 0.0;

        if (is_array($relatedItems)) {
            foreach ($relatedItems as $item) {
                $unit = (float) ($item['price_related_service'] ?? 0);
                $qty  = max(1, (int) ($item['qty'] ?? 1));
                $relatedTotal += $unit * $qty;
            }
        }

        return $servicePrice + $relatedTotal;
    }
}
