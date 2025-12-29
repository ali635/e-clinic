<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Booking\Filament\Resources\VisitFollows\VisitFollowResource;

class ListVisitFollows extends ListRecords
{
    protected static string $resource = VisitFollowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
