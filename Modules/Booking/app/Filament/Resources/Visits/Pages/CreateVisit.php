<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Booking\Filament\Resources\Visits\VisitResource;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;
}
