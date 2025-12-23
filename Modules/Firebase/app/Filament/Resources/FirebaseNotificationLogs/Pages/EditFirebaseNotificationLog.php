<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\FirebaseNotificationLogResource;

class EditFirebaseNotificationLog extends EditRecord
{
    protected static string $resource = FirebaseNotificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
