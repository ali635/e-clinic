<?php

namespace Modules\Service\Filament\Resources\Services\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Service\Enums\DayOfWeek;
use Modules\Service\Filament\Resources\Services\ServiceResource;
use Modules\Service\Models\Service;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeSave($data): array
    {
        $data['locale'] = App::getLocale();
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $serviceId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'short_description' => $data['short_description'] ?? null,
            'description'      => $data['description'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = DB::table('service_translations')
            ->where('service_id', $serviceId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            DB::table('service_translations')
                ->where('service_id', $serviceId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['service_id'] = $serviceId;
            DB::table('service_translations')->insert($translationData);
        }

        // Update main service record (excluding translation fields)
        $serviceData = array_diff_key($data, array_flip(['name', 'short_description', 'description', 'locale']));
        if ($serviceData) {
            $record->update($serviceData);
        }


        if (isset($data['schedules']) && is_array($data['schedules'])) {
            // Remove existing schedules
            DB::table('service_schedules')->where('service_id', $serviceId)->delete();

            // Insert new schedules
            foreach ($data['schedules'] as $schedule) {
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
                    'start_time'  => $schedule['start_time'] ?? null,
                    'end_time'    => $schedule['end_time'] ?? null,
                    'is_active'   => $schedule['is_active'] ?? true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        return Service::with('schedules')->find($serviceId);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
