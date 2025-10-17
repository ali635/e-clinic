<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Modules\Service\Filament\Resources\Services\ServiceResource;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return \DB::transaction(function () use ($data) {
            // Insert into services table
            $serviceId = \DB::table('services')->insertGetId([
                'price'    => $data['price']   ?? null,
                'slug'    => $data['slug']   ?? null,
                'image'    => $data['image']   ?? null,
                'status' => $data['status'] ?? true,
                'is_home' => $data['is_home'] ?? true,
                'start'    => $data['start'] ?? null,
                'end'    => $data['end'] ?? null,
                'patient_time_minute'    => $data['patient_time_minute'] ?? null,
                'order'    => $data['order']   ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into service_translations table
                \DB::table('service_translations')->insert([
                    'service_id'  => $serviceId,
                    'locale'      => App::getLocale(),
                    'name'        => $data['name'],
                    'description' => $data['description'] ?? null,
                    'short_description' => $data['short_description'] ?? null,

                ]);
            
            // Return a fresh model instance
            return \Modules\Service\Models\Service::find($serviceId);
        });
    }
}
