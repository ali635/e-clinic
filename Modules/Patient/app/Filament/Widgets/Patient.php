<?php

namespace Modules\Patient\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Patient\Models\Patient as ModelsPatient;

class Patient extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $patientCounts = ModelsPatient::selectRaw('city_id, COUNT(*) as patient_count')
            ->groupBy('city_id')
            ->with('city') // Eager load the city relationship
            ->get()
            ->map(function ($record) {
                return Stat::make(
                    $record->city?->name ?? $record->city?->translate('en')?->name ?? __('Unknown City'),
                    $record->patient_count
                )
                    ->description(__('Patients in this city'))
                    ->color('primary');
            })
            ->toArray();

        return $patientCounts;
    }
}
