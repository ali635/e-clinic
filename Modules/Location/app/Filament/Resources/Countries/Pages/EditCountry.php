<?php

namespace Modules\Location\Filament\Resources\Countries\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Location\Filament\Resources\Countries\CountryResource;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $countryId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = \DB::table('country_translations')
            ->where('country_id', $countryId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            \DB::table('country_translations')
                ->where('country_id', $countryId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['country_id'] = $countryId;
            \DB::table('country_translations')->insert($translationData);
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
