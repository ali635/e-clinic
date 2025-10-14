<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Booking\Models\Visit;
use Modules\Service\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Optional filters
        $isHome = $request->query('is_home');
        $lang   = $request->query('lang', app()->getLocale());

        // Set current language for translatable model
        app()->setLocale($lang);

        $query = Service::query()->where('status', 1);

        

        // Fetch services ordered by "order" column
        $services = $query->orderBy('order', 'asc')->get();

        return view('services.index', [
            'services' => $services,
            'lang' => $lang,
        ]);
    }

    public function show(Request $request, $slug)
    {

        $service = Service::with('translations')->where('slug', $slug)->firstOrFail();

        // set language for translations
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        $date = $request->query('date'); // optional date for slot generation

        // Build booked query:
        if ($date) {
            try {
                $dateCarbon = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid date format. Use YYYY-MM-DD.',
                ], 422);
            }

            $bookedQuery = Visit::where('service_id', $service->id)
                ->whereNotNull('arrival_time')
                ->whereDate('arrival_time', $dateCarbon);
        } else {
            // If no date given, return upcoming bookings (from now)
            $bookedQuery = Visit::where('service_id', $service->id)
                ->whereNotNull('arrival_time');
        }

        $bookedTimes = $bookedQuery
            ->orderBy('arrival_time')
            ->pluck('arrival_time')
            ->map(fn($t) => Carbon::parse($t)->toDateTimeString())
            ->toArray();



        // If an authenticated patient exists, tell if they have a booking for this service
        $bookedByAuth = false;
        $authPatient = auth('patient')->user();
        if ($authPatient) {
            $qb = Visit::where('service_id', $service->id)->where('patient_id', $authPatient->id);
            if ($date) {
                $qb->whereDate('arrival_time', $dateCarbon);
            } else {
                $qb->where('arrival_time', '>=', Carbon::now());
            }
            $bookedByAuth = $qb->exists();
        }

        return view('services.show', [
            'service'        => $service,
            'lang'           => $lang,
            'date'           => $date,
            'booked_times'   => $bookedTimes,      // array of datetime strings
            'booked_by_auth' => (bool) $bookedByAuth,
        ]);
    }
}
