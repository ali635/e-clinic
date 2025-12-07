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
        $patient->load(['country.translations', 'city.translations', 'diseasesMany.translations','referral']);

        return response()->json([
            'patient' => new PatientResource($patient),
        ]);
    }

    public function loyalty()
    {
        $patient = auth('api')->user();
        if (!$patient) {
            return response()->json(['message' => __('Unauthorized')], 401);
        }
        $completedVisits = $patient->visits()->where('is_arrival', true)->count();

        // Determine reward rating
        $rating = 0;
        $nextVisit = 0;
        $nextStar = 0 ;
        if ($completedVisits >= 15) {
            $rating = 4;
        } elseif ($completedVisits >= 10) {
            $rating = 3;
            $nextStar = 4;
            $nextVisit = 15 - $completedVisits;
        } elseif ($completedVisits >= 5) {
            $rating = 2;
            $nextVisit = 10 - $completedVisits;
            $nextStar = 3;
        } elseif ($completedVisits >= 3) {
            $rating = 1;
            $nextStar = 2;
            $nextVisit = 5 - $completedVisits;
        } else {
            $rating = 0;
            $nextVisit = 3 - $completedVisits;
            $nextStar = 1;
        }

        return response()->json([
            'stats' => [
                'completed_visits' => $completedVisits ?? 0,
                'next_visit' => $nextVisit ?? 0,
                'next_star' => $nextStar ?? 0,
                'reward_rating' => $rating,
            ],
        ]);
    }

    public function update(UpdatePatientProfileRequest $request)
    {
        $patient = auth('api')->user();
        if (!$patient) {
            return response()->json(['message' => __('Unauthorized')], 401);
        }

        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $diseaseIds = $data['diseases'] ?? null;
        unset($data['diseases']);

        $patient->update($data);

        if (!empty($diseaseIds) && is_array($diseaseIds)) {
            $patient->diseasesMany()->sync($diseaseIds);
        }

        return response()->json([
            'message' => __('Profile updated successfully'),
            'data'    => new PatientResource(
                $patient->fresh([
                    'country.translations',
                    'city.translations',
                    'area.translations',
                    'diseasesMany.translations',
                    'referral'
                ])
            )
        ]);
    }
}
