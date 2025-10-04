<?php

namespace Modules\Service\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $query = Service::query();

        if (!is_null($isHome)) {
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
}
