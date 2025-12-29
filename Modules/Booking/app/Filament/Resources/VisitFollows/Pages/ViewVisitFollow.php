<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Booking\Filament\Resources\VisitFollows\VisitFollowResource;

class ViewVisitFollow extends ViewRecord
{
    protected static string $resource = VisitFollowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
