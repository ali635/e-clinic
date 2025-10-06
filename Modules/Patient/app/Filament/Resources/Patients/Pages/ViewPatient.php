<?php

namespace Modules\Patient\Filament\Resources\Patients\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Patient\Filament\Resources\Patients\PatientResource;
use Modules\Patient\Filament\Widgets\PatientVisitCount;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PatientVisitCount::make([
                'record' => $this->record,
            ]),
        ];
    }
}
