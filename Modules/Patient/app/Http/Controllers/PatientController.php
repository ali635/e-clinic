<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Booking\Models\Feedback;
use Modules\Booking\Models\Visit;
use Modules\Location\Models\Area;
use Modules\Location\Models\City;
use Modules\Patient\Http\Requests\FeedbackRequest;
use Modules\Patient\Http\Requests\UpdatePatientProfileRequest;
use Modules\Patient\Models\Disease;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = auth('patient')->user();

        $patient->load('city', 'area', 'diseasesMany');

        $cities = City::where('status', 1)->orderBy('order', 'desc')->get();
        $areas = Area::where('status', 1)->orderBy('order', 'desc')->get();
        $diseases = Disease::get();


        $visits = $patient->visits ?? collect(); // ensure collection
        $totalVisits = $visits->count();

        // Determine stars based on visits
        $stars = 0;
        if ($totalVisits >= 15) {
            $stars = 4;
        } elseif ($totalVisits >= 10) {
            $stars = 3;
        } elseif ($totalVisits >= 5) {
            $stars = 2;
        } elseif ($totalVisits >= 3) {
            $stars = 1;
        }
        return view('patient.profile.edit', compact('patient', 'cities', 'areas', 'diseases', 'stars', 'totalVisits'));
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
        $visits = Visit::with(['service', 'relatedService', 'feedback'])
            ->where('patient_id', $patient->id)->orderByDesc('created_at')
            ->get();

        $totalVisits = $visits->count();

        // Determine stars based on number of visits
        $stars = 0;
        $nextGoal = null;

        if ($totalVisits >= 15) {
            $stars = 4;
        } elseif ($totalVisits >= 10) {
            $stars = 3;
            $nextGoal = 15;
        } elseif ($totalVisits >= 5) {
            $stars = 2;
            $nextGoal = 10;
        } elseif ($totalVisits >= 3) {
            $stars = 1;
            $nextGoal = 5;
        } else {
            $nextGoal = 3;
        }
        return view('patient.visits.index', compact('patient', 'visits', 'stars', 'nextGoal', 'totalVisits'));
    }

    public function showVisit($id)
    {
        $patient = auth('patient')->user();
        $visit = Visit::with(['service', 'relatedService', 'relatedService.relatedService'])
            ->where('patient_id', $patient->id)
            ->find($id);

        if (!$visit) {
            return redirect()->route('patient.visits');
        }
        return view('patient.visits.show', compact('patient', 'visit'));
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

    public function storeFeedback(FeedbackRequest $request)
    {
        $patient = auth('patient')->user();
        $data = $request->validated();
        $data['patient_id'] = $patient->id;
        Feedback::create($data);
        return redirect()->route('patient.feedback')->with('success', __('Feedback sent successfully'));
    }


    public function updateProfile(UpdatePatientProfileRequest $request)
    {
        $patient = auth('patient')->user();

        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $diseaseIds = $data['diseases'] ?? null;
        unset($data['diseases']);


        $patient->update($request->all());

        if (!empty($diseaseIds) && is_array($diseaseIds)) {
            $patient->diseasesMany()->sync($diseaseIds);
        }
        return redirect()->route('patient.profile')->with('success', __('Profile updated successfully'));
    }
}
