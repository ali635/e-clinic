<?php

namespace Modules\Location\Filament\Resources\Cities\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Location\Filament\Resources\Cities\CityResource;
use Modules\Location\Models\City;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        return DB::transaction(function () use ($data) {
            // Insert into cities table
            $cityId = DB::table('cities')->insertGetId([
                'status' => $data['status'] ?? true,
                'order'    => $data['order']   ?? 0,
                'country_id' => $data['country_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into city_translations table
            DB::table('city_translations')->insert([
                'city_id'  => $cityId,
                'locale'      => App::getLocale(),
                'name'        => $data['name'],

            ]);
            // Return a fresh model instance
            return City::find($cityId);
        });
    }
}
