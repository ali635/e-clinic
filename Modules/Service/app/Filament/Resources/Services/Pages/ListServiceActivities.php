<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use pxlrbt\FilamentActivityLog\Pages\ListActivities;
use Modules\Service\Filament\Resources\Services\ServiceResource;

class ListServiceActivities extends ListActivities
{
    protected static string $resource = ServiceResource::class;
}
