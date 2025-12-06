<?php

namespace Modules\Patient\Filament\Resources\Patients\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Patient\Filament\Resources\Patients\PatientResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        $patient = static::getModel()::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => $data['password'],
            'address' => $data['address'],
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
            'hear_about_us' => $data['hear_about_us'],
            'referral_id' => $data['referral_id'],
        ]);

        foreach ($data['disease_id'] as $item) {
            DB::table('patient_diseases')->insert([
                'patient_id' => $patient->id,
                'disease_id' => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $patient;
    }
}
