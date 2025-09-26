<?php

namespace Modules\Patient\Filament\Resources\Diseases\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Patient\Filament\Resources\Diseases\DiseaseResource;

class EditDisease extends EditRecord
{
    protected static string $resource = DiseaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
