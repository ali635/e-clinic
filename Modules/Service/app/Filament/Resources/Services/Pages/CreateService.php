<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Service\Filament\Resources\Services\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;
}
