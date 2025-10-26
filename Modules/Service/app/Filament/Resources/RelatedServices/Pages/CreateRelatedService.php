<?php

namespace Modules\Service\Filament\Resources\RelatedServices\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Service\Filament\Resources\RelatedServices\RelatedServiceResource;
use Modules\Service\Models\RelatedService;

class CreateRelatedService extends CreateRecord
{
    protected static string $resource = RelatedServiceResource::class;

  protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return DB::transaction(function () use ($data) {
            $relatedServiceId = DB::table('related_services')->insertGetId([
                'price'    => $data['price']   ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            DB::table('related_service_translations')->insert([
                'related_service_id'  => $relatedServiceId,
                'locale'      => App::getLocale(),
                'name'        => $data['name'],

            ]);


            return RelatedService::find($relatedServiceId);
        });
    }
}
