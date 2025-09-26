<?php

namespace Modules\Patient\Filament\Resources\Patients\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Patient\Filament\Resources\Patients\PatientResource;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
}
