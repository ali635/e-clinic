<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Booking\Filament\Resources\VisitWaitings\VisitWaitingResource;

class ViewVisitWaiting extends ViewRecord
{
    protected static string $resource = VisitWaitingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
