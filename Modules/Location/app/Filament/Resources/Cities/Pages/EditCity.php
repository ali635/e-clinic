<?php

namespace Modules\Location\Filament\Resources\Cities\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Location\Filament\Resources\Cities\CityResource;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $cityId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = DB::table('city_translations')
            ->where('city_id', $cityId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            DB::table('city_translations')
                ->where('city_id', $cityId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['city_id'] = $cityId;
            DB::table('city_translations')->insert($translationData);
        }

        // Update main post record (excluding translation fields)
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
