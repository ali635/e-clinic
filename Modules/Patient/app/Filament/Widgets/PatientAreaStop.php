<?php

namespace Modules\Patient\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Patient\Models\Patient as ModelsPatient;

class PatientArea extends StatsOverviewWidget
{
    // protected function getStats(): array
    // {
    //     $patientCounts = ModelsPatient::selectRaw('area_id, COUNT(*) as patient_count')
    //         ->groupBy('area_id')
    //         ->with('area') // Eager load the area relationship
    //         ->get()
    //         ->map(function ($record) {
    //             return Stat::make(
    //                 $record->area?->name ?? $record->area?->translate('en')?->name ?? __('Unknown area'),
    //                 $record->patient_count
    //             )
    //                 ->description(__('Patients in this area'))
    //                 ->color('primary');
    //         })
    //         ->toArray();

    //     return $patientCounts;
    // }
}
