<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;

class EditRelatedService extends EditRecord
{
    protected static string $resource = RelatedServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
