<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Service\Filament\Resources\Services\ServiceResource;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeSave($data): array
    {

        $data['locale'] = App::getLocale();
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $serviceId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'description'      => $data['description'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = \DB::table('service_translations')
            ->where('service_id', $serviceId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            \DB::table('service_translations')
                ->where('service_id', $serviceId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['service_id'] = $serviceId;
            \DB::table('service_translations')->insert($translationData);
        }

        // Update main service record (excluding translation fields)
        $serviceData = array_diff_key($data, array_flip(['name', 'short_description', 'description', 'locale']));
        if ($serviceData) {
            $record->update($serviceData);
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
