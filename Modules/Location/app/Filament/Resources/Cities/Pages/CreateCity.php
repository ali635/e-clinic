<?php

namespace Modules\Location\Filament\Resources\Cities\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Location\Filament\Resources\Cities\CityResource;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;
}
