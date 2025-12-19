<?php

namespace Modules\Room\Filament\Resources\Rooms\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Room\Filament\Resources\Rooms\RoomResource;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
