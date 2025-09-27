<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;

class CreateRelatedService extends CreateRecord
{
    protected static string $resource = RelatedServiceResource::class;
}
