<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Service\Enums\DayOfWeek;
use Modules\Service\Filament\Resources\Services\ServiceResource;
use Modules\Service\Models\Service;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return DB::transaction(function () use ($data) {
            // Insert into services table
            $serviceId = DB::table('services')->insertGetId([
                'price'    => $data['price']   ?? null,
                'slug'    => $data['slug']   ?? null,
                'image'    => $data['image']   ?? null,
                'status' => $data['status'] ?? true,
                'is_home' => $data['is_home'] ?? true,
                'patient_time_minute'    => $data['patient_time_minute'] ?? null,
                'order'    => $data['order']   ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            // Insert into service_translations table
            DB::table('service_translations')->insert([
                'service_id'  => $serviceId,
                'locale'      => App::getLocale(),
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'short_description' => $data['short_description'] ?? null,

            ]);

            // 3️⃣ Insert schedules (if provided)
            if (!empty($data['schedules']) && is_array($data['schedules'])) {
                foreach ($data['schedules'] as $schedule) {
                    // Validate and normalize day value
                    $dayValue = is_string($schedule['day_of_week'])
                        ? $schedule['day_of_week']
                        : ($schedule['day_of_week'] instanceof DayOfWeek
                            ? $schedule['day_of_week']->value
                            : null);

                    if (!$dayValue || !in_array($dayValue, array_column(DayOfWeek::cases(), 'value'))) {
                        continue; // skip invalid day
                    }

                    DB::table('service_schedules')->insert([
                        'service_id' => $serviceId,
                        'day_of_week' => $dayValue,
                        'start_time' => $schedule['start_time'] ?? null,
                        'end_time'   => $schedule['end_time'] ?? null,
                        'is_active'  => $schedule['is_active'] ?? true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 4️⃣ Return the created Service model with relations
            return Service::with('schedules')->find($serviceId);
        });
    }
}
