<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Patient\Http\Requests\UpdatePatientProfileRequest;
use Modules\Patient\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function index()
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json(['message' => __('Unauthorized')], 401);
        }

        // Load relationships for full details
        $patient->load(['country.translations', 'city.translations', 'diseasesMany.translations']);

        return new PatientResource($patient);
    }

    public function update(UpdatePatientProfileRequest $request)
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json(['message' => __('Unauthorized')], 401);
        }

        $data = $request->validated();

        // Handle password update
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $patient->update($data);

        return response()->json([
            'message' => __('Profile updated successfully'),
            'data'    => new PatientResource($patient->fresh(['country.translations', 'city.translations', 'diseasesMany.translations']))
        ]);
    }
}
