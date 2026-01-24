<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Booking\Filament\Resources\VisitWaitings\VisitWaitingResource;

class EditVisitWaiting extends EditRecord
{
    protected static string $resource = VisitWaitingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
