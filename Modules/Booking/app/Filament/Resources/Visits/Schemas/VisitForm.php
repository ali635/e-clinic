<?php

namespace Modules\Booking\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
// use Filament\Forms\Components\CKEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Kahusoftware\FilamentCkeditorField\CKEditor;
use Modules\Booking\Enums\PaymentMethod;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\RelatedService;
use Modules\Service\Models\Service;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Booking\Models\Visit;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // ===== General info (patient, service, price, total) =====
            Section::make(__('General Information'))
                ->columns(2)
                ->columnSpan(1)
                ->schema([
                    // Patient select
                    Select::make('patient_id')
                        ->label(__('patients'))
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->default(fn() => request()->query('patient_id'))
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
                            // recalc totals
                            self::updateTotals($get, $set);
                        })
                        ->searchable()
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
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            // Recalculate total_after_discount when total_price changes
                            $discount = (float) ($get('discount_amount') ?? 0);
                            $set('total_after_discount', max(0, (float) $state - $discount));
                        })
                        ->columnSpan(1),

                    TextInput::make('discount_amount')
                        ->label(__('Discount Amount'))
                        ->suffixIcon('heroicon-m-currency-dollar')
                        ->default(0)
                        ->numeric()
                        ->reactive()
                        ->dehydrated(true)
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            // Calculate total_after_discount = total_price - discount_amount
                            $totalPrice = (float) ($get('total_price') ?? 0);
                            $discount = (float) ($state ?? 0);
                            $set('total_after_discount', max(0, $totalPrice - $discount));
                        })
                        ->helperText(__('Enter discount amount to subtract from total'))
                        ->columnSpan(1),

                    TextInput::make('total_after_discount')
                        ->label(__('Total After Discount'))
                        ->suffixIcon('heroicon-m-currency-dollar')
                        ->disabled()
                        ->default(0)
                        ->numeric()
                        ->reactive()
                        ->dehydrated(true)
                        ->helperText(__('Auto-calculated: total price - discount'))
                        ->columnSpan(1),
                ]),

            // ===== Arrival info =====
            Section::make(__('Arrival Information'))
                ->columns(2)
                ->columnSpan(1)
                ->schema([
                    DateTimePicker::make('arrival_time')
                        ->label(__('Arrival Time'))
                        ->helperText(__('Expected / actual arrival time'))
                        ->columnSpan(1),

                    Select::make('status')
                        ->label(__('Status'))
                        ->options([
                            'pending' => __('Pending'),
                            'complete' => __('Complete'),
                            'cancelled' => __('Cancelled'),
                        ])
                        ->default('pending')
                        ->columnSpan(1),

                    Select::make('payment_method')
                        ->label(__('Payment Method'))
                        ->options(PaymentMethod::options())
                        ->default(PaymentMethod::Cash)
                        ->columnSpan(1),

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
                            self::updateTotals($get, $set);
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

                                    // recompute totals for whole form
                                    self::updateTotals($get, $set);
                                })
                                ->searchable(),

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
                                    self::updateTotals($get, $set);
                                }),
                        ]),
                ]),

            Section::make(__('Blood Pressure'))
                ->columns(3)
                ->columnSpan(2)
                ->schema([
                    TextInput::make('sys')
                        ->numeric(),
                    TextInput::make('dia')
                        ->numeric(),
                    TextInput::make('pulse_rate')
                        ->numeric(),
                ]),


            Section::make(__('Anthropometric Measurements'))
                ->columns(3)
                ->columnSpan(2)
                ->schema([
                    TextInput::make('weight')
                        ->numeric()
                        ->suffix('kg')
                        ->minValue(1)
                        ->maxValue(500)
                        ->live(onBlur: true) // Trigger on blur for better UX
                        ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateBMI($get, $set))
                        ->columnSpan(1),

                    TextInput::make('height')
                        ->numeric()
                        ->suffix('cm')
                        ->minValue(50)
                        ->maxValue(300)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateBMI($get, $set))
                        ->columnSpan(1),

                    TextInput::make('body_max_index')
                        ->numeric()
                        ->suffix('kg/m²')
                        ->helperText('Auto-calculated from weight and height')
                        ->placeholder('Calculated automatically')
                        ->columnSpan(1),
                ]),


            // ===== Attachments =====
            Section::make(__('Attachments'))
                ->columns(1)
                ->columnSpan(2)
                ->schema([
                    FileUpload::make('lab_tests')
                        ->label(__('Lab tests \ x-rays'))
                        ->disk('public')
                        ->directory('visit')
                        ->multiple()
                        ->helperText(__('Drag & drop or browse to upload multiple lab tests and x-rays')),

                    CKEditor::make('notes')
                        ->label(__('Notes')),
                ]),

            // ===== Doctor & Treatment Notes =====
            Section::make(__('Doctor & Treatment Notes'))
                ->columns(1)
                ->columnSpan(2)
                ->schema([

                    TagsInput::make('chief_complaint')
                        ->label(__('chief complaint'))
                        ->separator(',')
                        ->suggestions(fn() => self::getSuggestionsForField('chief_complaint'))
                        ->helperText(__('chief complaint')),

                    CKEditor::make('doctor_description')
                        ->label(__('Doctor Description'))
                        ->helperText(__('Clinical notes and observations')),

                    TagsInput::make('medical_history')
                        ->label(__('past medical history'))
                        ->separator(',')
                        ->suggestions(fn() => self::getSuggestionsForField('medical_history'))
                        ->helperText(__('past medical history')),

                    TagsInput::make('medicines_list')
                        ->label(__('Past drug hiatory'))
                        ->separator(',')
                        ->suggestions(fn() => self::getMedicineSuggestions())
                        ->helperText(__('Type medicine names, suggestions from previous visits')),

                    TagsInput::make('diagnosis')
                        ->label(__('diagnosis'))
                        ->separator(',')
                        ->suggestions(fn() => self::getSuggestionsForField('diagnosis'))
                        ->helperText(__('diagnosis')),

                    TagsInput::make('treatment')
                        ->label(__('prescription'))
                        ->separator(',')
                        ->suggestions(fn() => self::getSuggestionsForField('treatment'))
                        ->helperText(__('Treatment plan and instructions')),


                ]),

            // ===== Secretary & Patient Notes =====
            Section::make(__('Secretary & Patient'))
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    CKEditor::make('secretary_description')
                        ->label(__('Secretary Description'))
                        ->helperText(__('Administrative notes, reminders')),



                    CKEditor::make('patient_description')
                        ->label(__('Patient Description'))
                        ->helperText(__('Patient description')),

                    FileUpload::make('attachment')
                        ->label(__('Attachment'))
                        ->disk('public')
                        ->directory('visit')
                        ->columnSpanFull()
                        ->helperText(__('Patient attachments')),
                ]),

            Section::make(__('AI Assistant'))
                ->columns(1)
                ->columnSpan(2)
                ->visible(fn(?Visit $record): bool => $record !== null && !empty($record->result_ai) && $record->result_ai !== '<p></p>')
                ->schema([
                    RichEditor::make('result_ai')
                        ->label(__('AI Assistant Result'))
                        ->helperText(__('AI-generated medical analysis and insights'))
                        ->disabled(),

                ]),
        ]);
    }

    /**
     * Calculate total price using the form $get callable.
     */
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
                $qty = max(1, (int) ($item['qty'] ?? 1));
                $relatedTotal += $unit * $qty;
            }
        }

        return $servicePrice + $relatedTotal;
    }

    /**
     * Update both total_price and total_after_discount fields.
     */
    protected static function updateTotals(callable $get, callable $set): void
    {
        $totalPrice = self::calculateTotal($get);
        $set('total_price', $totalPrice);

        $discount = (float) ($get('discount_amount') ?? 0);
        $set('total_after_discount', max(0, $totalPrice - $discount));
    }

    protected static function calculateBMI(Get $get, Set $set): void
    {
        $weight = $get('weight');
        $height = $get('height');

        // Only calculate if both values are present and valid
        if (filled($weight) && filled($height) && $height > 0) {
            // Convert height from cm to meters
            $heightInMeters = (float) $height / 100;

            if ($heightInMeters > 0) {
                $bmi = round((float) $weight / ($heightInMeters ** 2), 1);
                $set('body_max_index', $bmi);
            }
        }
    }

    /**
     * Get unique suggestions for a TagsInput field from previous visits.
     *
     * @param string $field The field name to get suggestions for
     * @return array Array of unique suggestions
     */
    protected static function getSuggestionsForField(string $field): array
    {
        return Visit::query()
            ->whereNotNull($field)
            ->pluck($field)
            ->flatten()
            ->flatMap(function ($value) {
                // If value is a string, split by comma
                if (is_string($value)) {
                    return array_map('trim', explode(',', $value));
                }
                // If value is already an array, return as is
                return is_array($value) ? $value : [$value];
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Get medicine suggestions from Medicine model and previous visit medicines.
     *
     * @return array Array of unique medicine suggestions
     */
    protected static function getMedicineSuggestions(): array
    {
        // Get medicine names from the Medicine model
        $medicineNames = \Modules\Medicine\Models\Medicine::query()
            ->pluck('name')
            ->toArray();

        // Get medicine names from previous visits' medicines_list
        $visitMedicines = self::getSuggestionsForField('medicines_list');

        // Combine and return unique values
        return collect($medicineNames)
            ->merge($visitMedicines)
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }
}
