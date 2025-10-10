<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Modules\Booking\Filament\Resources\Visits\VisitResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListVisitActivities extends ListActivities
{
    protected static string $resource = VisitResource::class;
}
