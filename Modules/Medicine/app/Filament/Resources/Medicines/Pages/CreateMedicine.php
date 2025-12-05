<?php

namespace Modules\Medicine\Filament\Resources\Medicines\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Medicine\Filament\Resources\Medicines\MedicineResource;

class CreateMedicine extends CreateRecord
{
    protected static string $resource = MedicineResource::class;
}
