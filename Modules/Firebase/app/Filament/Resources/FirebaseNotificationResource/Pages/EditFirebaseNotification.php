<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationResource\Pages;

use Modules\Firebase\Filament\Resources\FirebaseNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirebaseNotification extends EditRecord
{
    protected static string $resource = FirebaseNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
