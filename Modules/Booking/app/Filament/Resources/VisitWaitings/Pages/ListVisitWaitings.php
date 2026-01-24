<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Booking\Filament\Resources\VisitWaitings\VisitWaitingResource;

class ListVisitWaitings extends ListRecords
{
    protected static string $resource = VisitWaitingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
