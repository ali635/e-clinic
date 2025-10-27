<?php

namespace Modules\Booking\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Modules\Booking\Http\Requests\VisitRequest;
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

        $completedVisits = $patient->visits()->where('is_arrival', true)->count();
        $notCompletedVisits = $patient->visits()->where('is_arrival', false)->count();


        $visitCompleted = $patient->visits()->where('is_arrival', true)->with(['service', 'relatedService', 'relatedService.relatedService' ,'feedback'])->get();

        $visitNotCompleted = $patient->visits()->where('is_arrival', false)->with(['service', 'relatedService','relatedService.relatedService','feedback'])->get();

        
        return response()->json([
            'completed_visits' => $completedVisits ?? 0,
            'not_completed_visits' => $notCompletedVisits ?? 0,
            'visitCompleted' =>  VisitResource::collection($visitCompleted),
            'visitNotCompleted' =>  VisitResource::collection($visitNotCompleted),
        ]);
    }

    public function show($id)
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $visit = Visit::with(['service', 'relatedService','relatedService.relatedService','feedback'])
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
        $visit->save();


        return response()->json([
            'status'  => true,
            'message' => __('Service Registration successful'),
            'data'    => [
                'visit' => $visit,
            ],
        ], 201);
    }
}
