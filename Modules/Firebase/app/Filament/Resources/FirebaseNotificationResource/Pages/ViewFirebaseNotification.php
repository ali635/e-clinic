<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationResource\Pages;

use Modules\Firebase\Filament\Resources\FirebaseNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFirebaseNotification extends ViewRecord
{
    protected static string $resource = FirebaseNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
