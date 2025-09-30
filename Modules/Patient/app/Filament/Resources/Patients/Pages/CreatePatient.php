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
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],

            'date_of_birth' => $data['date_of_birth'],
            'status' => $data['status'],

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
