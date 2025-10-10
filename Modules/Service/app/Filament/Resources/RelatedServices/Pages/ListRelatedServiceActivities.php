<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListRelatedServiceActivities extends ListActivities
{
    protected static string $resource = RelatedServiceResource::class;
}
