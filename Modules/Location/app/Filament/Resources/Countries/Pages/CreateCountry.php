<?php

namespace Modules\Location\Filament\Resources\Countries\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Modules\Location\Filament\Resources\Countries\CountryResource;
use Modules\Location\Models\Country;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        return \DB::transaction(function () use ($data) {
            // Insert into countrys table
            $countryId = \DB::table('countries')->insertGetId([
                'status' => $data['status'] ?? true,
                'order'    => $data['order']   ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into country_translations table
                \DB::table('country_translations')->insert([
                    'country_id'  => $countryId,
                    'locale'      => App::getLocale(),
                    'name'        => $data['name'],

                ]);
            
            // Return a fresh model instance
            return Country::find($countryId);
        });
    }
}
