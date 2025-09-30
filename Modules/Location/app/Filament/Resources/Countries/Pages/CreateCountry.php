<?php

namespace Modules\Location\Filament\Resources\Countries\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Location\Filament\Resources\Countries\CountryResource;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
