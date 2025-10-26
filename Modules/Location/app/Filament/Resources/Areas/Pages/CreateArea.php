<?php

namespace Modules\Location\Filament\Resources\Areas\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Location\Filament\Resources\Areas\AreaResource;
use Modules\Location\Models\Area;

class CreateArea extends CreateRecord
{
    protected static string $resource = AreaResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        return DB::transaction(function () use ($data) {
            // Insert into areas table
            $areaId = DB::table('areas')->insertGetId([
                'status' => $data['status'] ?? true,
                'order'    => $data['order']   ?? 0,
                'city_id' => $data['city_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into area_translations table
            DB::table('area_translations')->insert([
                'area_id'  => $areaId,
                'locale'      => App::getLocale(),
                'name'        => $data['name'],

            ]);
            // Return a fresh model instance
            return Area::find($areaId);
        });
    }
}
