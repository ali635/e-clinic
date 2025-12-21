<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationResource\Pages;

use Modules\Firebase\Filament\Resources\FirebaseNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFirebaseNotifications extends ListRecords
{
    protected static string $resource = FirebaseNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
