<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;

class EditRelatedService extends EditRecord
{
    protected static string $resource = RelatedServiceResource::class;

     protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $cityId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();
        $translationData = [
            'name'             => $data['name'] ?? null,
            'locale'           => $locale,
        ];

        $exists = DB::table('related_service_translations')
            ->where('related_service_id', $cityId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            DB::table('related_service_translations')
                ->where('related_service_id', $cityId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            $translationData['related_service_id'] = $cityId;
            DB::table('related_service_translations')->insert($translationData);
        }

        $countryData = array_diff_key($data, array_flip(['name', 'locale']));
        if ($countryData) {
            $record->update($countryData);
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
