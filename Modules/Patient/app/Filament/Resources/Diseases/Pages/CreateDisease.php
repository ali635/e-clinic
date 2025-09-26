<?php

namespace Modules\Patient\Filament\Resources\Diseases\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Patient\Filament\Resources\Diseases\DiseaseResource;

class CreateDisease extends CreateRecord
{
    protected static string $resource = DiseaseResource::class;
}
