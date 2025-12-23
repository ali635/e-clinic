<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\FirebaseNotificationLogResource;

class ViewFirebaseNotificationLog extends ViewRecord
{
    protected static string $resource = FirebaseNotificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
