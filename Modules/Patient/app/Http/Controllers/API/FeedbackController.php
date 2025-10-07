<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Feedback;
use Modules\Patient\Http\Resources\DiseaseResource;
use Modules\Patient\Models\Disease;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $patient = auth('api')->user();
        $feedback = Feedback::where([
            ['patient_id', $patient->id],
            ['visit_id',$request->query('visit_id')]
        ])->first();
        return DiseaseResource::collection($feedback);
    }

    public function store(Request $request)
    {
        $patient = auth('api')->user();
        $data = $request->only(['visit_id', 'comments', 'rating']);
        $data['patient_id'] = $patient->id;
        $feedback = Feedback::create($data);
        return response()->json(['message' => __('Feedback submitted successfully'), 'data' => $feedback], 201);
    }
}
