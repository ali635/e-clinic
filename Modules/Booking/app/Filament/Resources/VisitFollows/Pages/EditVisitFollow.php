<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Booking\Filament\Resources\VisitFollows\VisitFollowResource;

class EditVisitFollow extends EditRecord
{
    protected static string $resource = VisitFollowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
