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
                    'address' => $data['address'] ?? '',
                    'gender' => $data['gender'],
                    'phone' => $data['phone'],
                    'other_phone' => $data['other_phone'],
                    'country_id' => $data['country_id'],
                    'city_id' => $data['city_id'],
                    'area_id' => $data['area_id'],
                    'marital_status' => $data['marital_status'],
                    'date_of_birth' => $data['date_of_birth'],
                    'status' => $data['status'],
                    'img_profile' => $data['img_profile'],
                    'hear_about_us' => $data['hear_about_us']?? '',
                    'referral_id' => $data['referral_id'],
                ]);
                if (!empty($data['password'])) {
                    $record->update([
                        'password' => $data['password'],
                    ]);
                }
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
