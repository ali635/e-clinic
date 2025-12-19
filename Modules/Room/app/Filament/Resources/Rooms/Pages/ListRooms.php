<?php

namespace Modules\Room\Filament\Resources\Rooms\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Room\Filament\Resources\Rooms\RoomResource;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
