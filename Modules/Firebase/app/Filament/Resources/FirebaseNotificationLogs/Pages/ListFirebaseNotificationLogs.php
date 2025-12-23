<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\FirebaseNotificationLogResource;

class ListFirebaseNotificationLogs extends ListRecords
{
    protected static string $resource = FirebaseNotificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
