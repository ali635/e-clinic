<?php

namespace Modules\Booking\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Http\Resources\VisitResource;
use Modules\Booking\Models\Visit;

class BookingController extends Controller
{
    /**
     * Get all visits for the authenticated patient.
     */
    public function index(Request $request)
    {
        $patient = auth('api')->user();
        if (!$patient) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $visits = Visit::with(['service', 'relatedService'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('created_at')
            ->get();

        return VisitResource::collection($visits);
    }

    public function show($id)
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $visit = Visit::with(['service', 'relatedService'])
            ->where('patient_id', $patient->id)
            ->find($id);

        if (!$visit) {
            return response()->json(['message' => 'Visit not found'], 404);
        }

        return new VisitResource($visit);
    }
}
