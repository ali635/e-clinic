<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Request;
use Modules\Booking\Filament\Resources\Visits\VisitResource;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Pre-fill patient_id from query parameter if provided
        if ($patientId = Request::query('patient_id')) {
            $data['patient_id'] = (int) $patientId;
        }

        return $data;
    }
}

