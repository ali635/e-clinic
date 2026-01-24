<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Booking\Filament\Resources\VisitWaitings\VisitWaitingResource;

class CreateVisitWaiting extends CreateRecord
{
    protected static string $resource = VisitWaitingResource::class;
}
