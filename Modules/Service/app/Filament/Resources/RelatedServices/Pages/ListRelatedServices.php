<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;

class ListRelatedServices extends ListRecords
{
    protected static string $resource = RelatedServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
