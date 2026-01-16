<?php

namespace Modules\Booking\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Location\Models\City;
use Modules\Patient\Models\Patient;
use Modules\Booking\Models\Visit;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class VisitPatientImporter implements ToCollection, WithHeadingRow ,WithChunkReading
{
    public function collection(Collection $rows)
    {
        Log::info('VisitPatientImporter: Starting chunk processing. Rows count: ' . $rows->count());
        $startTime = microtime(true);

        // 1. Optimization: Pre-fetch existing patients for this chunk
        // Note: Using 'phone_number' based on your Excel structure
        $phones = $rows->pluck('phone_number')->filter()->unique()->toArray();
        $existingPatients = Patient::whereIn('phone', $phones)->get()->keyBy('phone');

        Log::info('VisitPatientImporter: Found ' . $existingPatients->count() . ' existing patients in this chunk.');

        $processedCount = 0;
        $errorCount = 0;

        foreach ($rows as $index => $row) {
            // Clean up inputs - Mapping based on your Excel headers
            $phone = trim($row['phone_number'] ?? '');
            $name = trim($row['name'] ?? '');

            // Skip empty rows where essential data is missing
            if (empty($phone) && empty($name)) {
                continue;
            }

            Log::info("VisitPatientImporter: Processing row index {$index}. Status: Start. Phone: {$phone}, Name: {$name}");

            DB::beginTransaction();
            try {
                // 1. Handle Patient Logic
                $patient = $existingPatients->get($phone);

                $patientAction = 'Found';
                if (!$patient) {
                    $patientAction = 'Creating';
                    $patient = new Patient();
                    $patient->password = Hash::make('12345678'); // Default password
                    // Default gender if missing or match
                    $gender = isset($row['gender']) ? strtolower($row['gender']) : null;
                    $patient->gender = $gender;
                    $patient->status = 1; // Active
                }

                // Update/Fill Patient Attributes
                if (!empty($name)) {
                    $patient->name = $name;
                }
                if (!empty($phone)) {
                    $patient->phone = $phone;
                }
                // Map 'adress' typo from Excel to 'address'
                if (isset($row['address'])) {
                    $patient->address = $row['address'];

                    $city = City::whereHas('translations', function ($query) use ($row) {
                        $query->where('name', $row['address']);
                    })->first();

                    if ($city) {
                        $patient->city_id = $city->id;
                        $patient->country_id = $city->country_id;
                    }
                } else {
                    $patient->address = 'no address';
                }

                if (isset($row['referal_from_doctor'])) {
                    $patient->hear_about_us = $row['referal_from_doctor'];
                }

                if (isset($row['marital_status'])) {
                    $patient->marital_status = $row['marital_status'];
                }
                // Map 'job' if you have a field for it, otherwise skip or put in notes

                // Saving date of birth if available (not in your sample, but keeping logic)
                if (!empty($row['age'])) {
                    $patient->date_of_birth = $row['age'];
                }

                $patient->status = 1;
                $patient->save();
                Log::info("VisitPatientImporter: Patient {$patientAction}. ID: {$patient->id}");

                // Update local map
                if (!$existingPatients->has($phone)) {
                    $existingPatients->put($phone, $patient);
                }

                // 2. Handle Visit Logic
                $visit = new Visit();
                $visit->patient_id = $patient->id;

                // Visit Fields Mapping
                // 'date' -> arrival_time
                if (!empty($row['date'])) {
                    $visit->arrival_time = $this->parseDate($row['date']);
                }

                // Medical Data Mapping
                // 'cc' -> chief_complaint
                if (!empty($row['cc'])) {
                    $visit->chief_complaint = [$row['cc']]; // Store as array
                }

                // 'c_history' -> medical_history 
                if (!empty($row['c_history'])) {
                    $visit->medical_history = [$row['c_history']];
                }

                // 'treatment' -> treatment
                if (!empty($row['treatment'])) {
                    $visit->treatment = [$row['treatment']];
                }

                // 'system_review', 'labrotery_investigation', etc.
                if (!empty($row['diagnois'])) {
                    $visit->diagnosis = [$row['diagnois']];
                }

                // Vital Signs (handling typos in Excel)
                $visit->sys = $row['sys'] ?? null;
                $visit->dia = $row['dia'] ?? null;
                $visit->pulse_rate = $row['palse_rate'] ?? null; // 'palse_rate' in Excel
                $visit->weight = $row['weight'] ?? null;
                $visit->height = $row['hight'] ?? null; // 'hight' in Excel
                $visit->body_max_index = $row['bmi'] ?? null;

                // Standard visit fields
                $visit->status = 'complete'; // Matches enum: pending, complete, cancelled
                $visit->is_arrival = true;

                // Additional fields if present
                $visit->notes = $row['notes'] ?? null;

                $visit->saveQuietly();
                Log::info("VisitPatientImporter: Visit Created. ID: {$visit->id} for Patient ID: {$patient->id}");

                DB::commit();
                $processedCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                $errorCount++;
                Log::error("VisitPatientImporter: Error processing row index {$index}. Message: " . $e->getMessage());
            }
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        Log::info("VisitPatientImporter: Chunk finished. Duration: {$duration}s. Processed: {$processedCount}. Errors: {$errorCount}.");
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Parse date helper
     */
    protected function parseDate($value): ?Carbon
    {
        if (empty($value)) {
            return null;
        }
        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value));
            }
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
