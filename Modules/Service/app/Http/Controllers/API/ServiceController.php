<?php

namespace Modules\Service\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Visit;
use Modules\Service\Http\Resources\ServiceDetailResource;
use Modules\Service\Models\Service;
use Modules\Service\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     * Example: GET /api/services?is_home=1&lang=en
     */
    public function index(Request $request)
    {
        // Optional filters
        $isHome = $request->query('is_home');
        $lang   = $request->query('lang', app()->getLocale());

        // Set current language for translatable model
        app()->setLocale($lang);

        $query = Service::query()->where('status', 1);

        if (!is_null($isHome) && $isHome == 1) {
            $query->where('is_home', (int) $isHome);
        }

        // Fetch services ordered by "order" column
        $services = $query->orderBy('order', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Services retrieved successfully',
            'lang' => $lang,
            'data' => ServiceResource::collection($services),
        ]);
    }

    public function show(Request $request, $id)
    {
        $service = Service::with(['translations','schedules'])->findOrFail($id);

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
        $authPatient = auth('api')->user();
        if ($authPatient) {
            $qb = Visit::where('service_id', $service->id)->where('patient_id', $authPatient->id);
            if ($date) {
                $qb->whereDate('arrival_time', $dateCarbon);
            } else {
                $qb->where('arrival_time', '>=', Carbon::now());
            }
            $bookedByAuth = $qb->exists();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'service'         => new ServiceDetailResource($service),
                'booked_times'    => $bookedTimes,      // array of datetime strings
                'booked_by_auth'  => (bool) $bookedByAuth,
            ],
        ]);
    }
}
