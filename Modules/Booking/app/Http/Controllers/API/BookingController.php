<?php

namespace Modules\Booking\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Modules\Booking\Http\Requests\VisitRequest;
use Modules\Booking\Http\Resources\VisitHomeResource;
use Modules\Booking\Http\Resources\VisitResource;
use Modules\Booking\Models\Visit;
use Modules\Service\Models\Service;

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

        $now = Carbon::now();

        // Eager load all visits once
        $visits = $patient->visits()->with(['service'])
            ->get();

        // Categorize in memory (no extra SQL)
        $visitCompleted = $visits->where('is_arrival', true);

        $visitPending = $visits->where('is_arrival', false)
            ->filter(fn($v) => $v->arrival_time > $now);

        $visitCancelled = $visits->where('is_arrival', false)
            ->filter(fn($v) => $v->arrival_time < $now);

        // Calculate counts (cheap, in memory)
        $completedVisits = $visitCompleted->count();
        $pendingVisits = $visitPending->count();
        $cancelledVisits = $visitCancelled->count();

        return response()->json([
            'completed_visits' => $completedVisits,
            'pending_visits' => $pendingVisits,
            'cancelled_visits' => $cancelledVisits,
            'visitCompleted' => VisitHomeResource::collection($visitCompleted),
            'visitPending' => VisitHomeResource::collection($visitPending),
            'visitCancelled' => VisitHomeResource::collection($visitCancelled),
        ]);
    }

    public function show($id)
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $visit = Visit::with(['service', 'relatedService', 'relatedService.relatedService', 'feedback'])
            ->where('patient_id', $patient->id)
            ->find($id);

        if (!$visit) {
            return response()->json(['message' => 'Visit not found'], 404);
        }

        return new VisitResource($visit);
    }


    public function store(VisitRequest $request)
    {
        $patient = auth('api')->user();
        if (!$patient) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $service = Service::query()->find($request->service_id);

        if (!$service) {
            return response()->json(['message' => 'service not found'], 404);
        }

        $visit = new Visit();
        $visit->service_id = $request->service_id;
        $visit->price = $service->price;
        $visit->patient_id = $patient->id;
        $visit->arrival_time = $request->arrival_time;
        $visit->patient_description = $request->patient_description;
        $visit->total_price = $service->price;
        $visit->save();


        return response()->json([
            'status'  => true,
            'message' => __('Service Registration successful'),
            'data'    => [
                'visit' => $visit,
            ],
        ], 201);
    }
    public function storeWeb(VisitRequest $request)
    {
        $patientId = $request->patient_id;

        if (!$patientId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $service = Service::query()->find($request->service_id);

        if (!$service) {
            return response()->json(['message' => 'service not found'], 404);
        }

        $visit = new Visit();
        $visit->service_id = $request->service_id;
        $visit->price = $service->price;
        $visit->patient_id = $patientId;
        $visit->arrival_time = $request->arrival_time;
        $visit->patient_description = $request->patient_description;
        $visit->total_price = $service->price;
        $visit->save();


        return response()->json([
            'status'  => true,
            'message' => __('Service Registration successful'),
            'data'    => [
                'visit' => $visit,
                'arrival_time' => $visit->arrival_time
            ],
        ], 201);
    }
}
