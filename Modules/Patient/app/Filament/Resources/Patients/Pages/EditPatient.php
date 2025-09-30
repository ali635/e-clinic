<?php

namespace Modules\Patient\Filament\Resources\Patients\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Patient\Filament\Resources\Patients\PatientResource;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            return DB::transaction(function () use ($record, $data) {
                $record->update([
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'address' => $data['address'],
                    'gender' => $data['gender'],
                    'phone' => $data['phone'],
                    'country_id' => $data['country_id'],
                    'city_id' => $data['city_id'],
                    'date_of_birth' => $data['date_of_birth'],
                    'status' => $data['status'],
                ]);
                $record->diseases()->delete();
                if (!empty($data['disease_id']) && is_array($data['disease_id'])) {
                    foreach ($data['disease_id'] as $item) {
                        $record->diseases()->create([
                            'disease_id' => $item,
                        ]);
                    }
                }
                return $record;
            });
        } catch (\Exception $e) {
            Log::error('Failed to update RequisitionTemplate', [
                'template_id' => $record->id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to update template: ' . $e->getMessage());
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
