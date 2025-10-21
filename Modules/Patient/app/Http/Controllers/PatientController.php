<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Feedback;
use Modules\Booking\Models\Visit;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = auth('patient')->user();
        return view('patient.profile.edit', compact('patient'));
    }

    public function statistical()
    {
        $patient = auth('patient')->user();

        $completedVisits = $patient->visits()->where('is_arrival', true)->count();
        $notCompletedVisits = $patient->visits()->where('is_arrival', false)->count();

        $date_of_last_visit = $patient->visits()->orderByDesc('created_at')->first()?->created_at?->format('d-m-Y') ?? '-';

        return view('patient.statistical.index', compact('patient', 'completedVisits', 'notCompletedVisits', 'date_of_last_visit'));
    }

    public function visits()
    {
        $patient = auth('patient')->user();
        $visits = Visit::with(['service', 'relatedService'])
            ->where('patient_id', $patient->id)->orderByDesc('created_at')
            ->get();
        return view('patient.visits.index', compact('patient', 'visits'));
    }

    public function showVisit($id)
    {
        // $patient = auth('patient')->user();
        // $visit = Visit::with(['service', 'relatedService'])
        //     ->where('patient_id', $patient->id)
        //     ->find($id);

        // if (!$visit) {
        //     return redirect()->route('patient.visits');
        // }
        return view('patient.visits.show');
    }

    public function history()
    {
        $patient = auth('patient')->user();

        $histories = Visit::select('doctor_description',  'created_at')
            ->where('patient_id', $patient->id)->orderByDesc('created_at')
            ->get();
        return view('patient.visits.history', compact('patient', 'histories'));
    }

    public function feedback()
    {
        $patient = auth('patient')->user();

        $feedbacks = Feedback::query()->where('patient_id', $patient->id)->with(['visit', 'visit.service'])->get();

        return view('patient.feedback.index', compact('feedbacks'));
    }
}
