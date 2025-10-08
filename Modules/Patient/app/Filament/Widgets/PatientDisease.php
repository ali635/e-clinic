<?php

namespace Modules\Patient\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Disease\Models\Disease;
use Modules\Patient\Models\PatientDisease as ModelsPatientDisease;

class PatientDisease extends ChartWidget
{
    protected ?string $heading = 'Patients per Disease';

    protected function getData(): array
    {
        // Query to get the count of patients per disease
        $diseaseCounts = ModelsPatientDisease::selectRaw('disease_id, COUNT(*) as patient_count')
            ->groupBy('disease_id')
            ->with('disease') // Eager load the disease relationship
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Patients per Disease'),
                    'data' => $diseaseCounts->pluck('patient_count')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $diseaseCounts->map(function ($record) {
                return $record->disease ? $record->disease->name : __('Unknown Disease');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
