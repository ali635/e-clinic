<?php

namespace Modules\Patient\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Booking\Models\Visit;

class PatientVisitCount extends StatsOverviewWidget
{
    public $record;

    protected function getStats(): array
    {
        if (isset($this->record)) {

            $totalVisits = Visit::where('patient_id', $this->record->id)->count();
            $completedVisits = Visit::where('patient_id', $this->record->id)->where('is_arrival', true)->count();

            return [
                Stat::make('Total Visits', $totalVisits)
                    ->description(__('Number of visits for this patient'))
                    ->color('success'),
                Stat::make('Completed Visits', $completedVisits)
                    ->description(__('Visits marked as arrived'))
                    ->color('primary'),
            ];
        }
        return [];
    }
}
