<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Feedback;
use Modules\Patient\Http\Requests\StoreFeedbackRequest;
use Modules\Patient\Http\Resources\DiseaseResource;
use Modules\Patient\Http\Resources\FeedbackResource;
use Modules\Patient\Models\Disease;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
         $patient = auth('api')->user();

        $query = Feedback::query()->where('patient_id', $patient->id)->with(['visit', 'visit.service']);

        

        $feedback = $query->get();

        // Use resource collection for consistent structure
        return FeedbackResource::collection($feedback);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $patient = auth('api')->user();

        $data = $request->validated();
        
        $query = Feedback::query()->where('patient_id', $patient->id)->where('visit_id', $data['visit_id']);

        if ($query->exists()) {
            return response()->json([
                'message' => __('Feedback already submitted for this visit'),
            ], 400);
        }

        $data['patient_id'] = $patient->id;

        $feedback = Feedback::create($data);

        return response()->json([
            'message' => __('Feedback submitted successfully'),
            'data' => $feedback,
        ], 201);
    }
}
