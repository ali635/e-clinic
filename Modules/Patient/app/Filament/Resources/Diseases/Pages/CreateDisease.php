<?php

namespace Modules\Patient\Filament\Resources\Diseases\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Patient\Filament\Resources\Diseases\DiseaseResource;
use Modules\Patient\Models\Disease;

class CreateDisease extends CreateRecord
{
    protected static string $resource = DiseaseResource::class;

     protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        return DB::transaction(function () use ($data) {
            $diseaseId = DB::table('diseases')->insertGetId([
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('disease_translations')->insert([
                'disease_id'  => $diseaseId,
                'locale'      => App::getLocale(),
                'name'        => $data['name'],

            ]);
            
            return Disease::find($diseaseId);
        });
    }
}
