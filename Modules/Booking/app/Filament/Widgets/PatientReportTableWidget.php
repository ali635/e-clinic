<?php

namespace Modules\Booking\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Modules\Booking\Services\ReportService;
use Illuminate\Database\Eloquent\Builder;
use Modules\Patient\Models\Patient;
use Filament\Support\Enums\FontWeight;

class PatientReportTableWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public ?array $filters = [];

    protected function getTableQuery(): Builder
    {
        $reportService = new ReportService();

        // Get data from service
        $reportData = $reportService->getPatientReportData($this->filters);

        // Apply patient type filter
        if (isset($this->filters['patient_type']) && $this->filters['patient_type']) {
            $type = ucfirst($this->filters['patient_type']);
            $reportData = $reportData->filter(function ($item) use ($type) {
                return $item['patient_type'] === $type;
            });
        }

        // Store in session for access in column rendering
        session(['patient_report_data_' . session()->getId() => $reportData->keyBy('id')->toArray()]);

        $patientIds = $reportData->pluck('id')->toArray();

        return Patient::query()
            ->whereIn('id', $patientIds ?: [0])
            ->with(['city', 'referral', 'visits']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),

                TextColumn::make('patient_type')
                    ->label('Type')
                    ->badge()
                    ->state(function (Patient $record): string {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        return $data[$record->id]['patient_type'] ?? 'N/A';
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'New' => 'primary',
                        'Old' => 'success',
                        default => 'gray',
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        $sorted = collect($data)->sortBy('patient_type', SORT_REGULAR, $direction === 'desc');
                        return $query->whereIn('id', $sorted->pluck('id')->toArray());
                    }),

                TextColumn::make('city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('referral.name')
                    ->label('Referral Source')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visits_count')
                    ->label('Total Visits')
                    ->state(function (Patient $record): int {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        return $data[$record->id]['visits_count'] ?? 0;
                    })
                    ->alignCenter()
                    ->badge()
                    ->color('warning')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        $sorted = collect($data)->sortBy('visits_count', SORT_REGULAR, $direction === 'desc');
                        return $query->whereIn('id', $sorted->pluck('id')->toArray());
                    }),

                TextColumn::make('latest_diagnosis')
                    ->label('Latest Diagnosis')
                    ->state(function (Patient $record): string {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        return $data[$record->id]['latest_diagnosis'] ?? 'N/A';
                    })
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('last_visit_date')
                    ->label('Last Visit')
                    ->state(function (Patient $record): string {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        return $data[$record->id]['last_visit_date'] ?? 'N/A';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        $data = session('patient_report_data_' . session()->getId(), []);
                        $sorted = collect($data)->sortBy('last_visit_date', SORT_REGULAR, $direction === 'desc');
                        return $query->whereIn('id', $sorted->pluck('id')->toArray());
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(\Carbon\Carbon::now()->startOfMonth()),

                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->default(\Carbon\Carbon::now()->endOfMonth()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        // Date filtering is handled in getTableQuery
                        if (isset($data['start_date']) && isset($data['end_date'])) {
                            $this->filters['start_date'] = $data['start_date'];
                            $this->filters['end_date'] = $data['end_date'];
                        }
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['start_date'] || !$data['end_date']) {
                            return null;
                        }
                        return 'From ' . \Carbon\Carbon::parse($data['start_date'])->toFormattedDateString()
                            . ' to ' . \Carbon\Carbon::parse($data['end_date'])->toFormattedDateString();
                    }),

                Tables\Filters\SelectFilter::make('city_id')
                    ->label('City')
                    ->options(function () {
                        return \Modules\Location\Models\City::with('translations')
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            $this->filters['city_id'] = $data['value'];
                        }
                        return $query;
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('referral_id')
                    ->label('Referral Source')
                    ->options(\Modules\Patient\Models\Referral::pluck('name', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            $this->filters['referral_id'] = $data['value'];
                        }
                        return $query;
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('patient_type')
                    ->label('Patient Type')
                    ->options([
                        'new' => 'New Patients',
                        'old' => 'Old Patients',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            $this->filters['patient_type'] = $data['value'];
                        }
                        return $query;
                    }),
            ])
            ->defaultSort('last_visit_date', 'desc')
            ->striped()
            ->headerActions([
                Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \Modules\Booking\Exports\PatientReportExport($this->filters),
                            'patient-reports-' . date('Y-m-d') . '.xlsx'
                        );
                    }),

                Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function () {
                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \Modules\Booking\Exports\PatientReportExport($this->filters),
                            'patient-reports-' . date('Y-m-d') . '.csv'
                        );
                    }),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
