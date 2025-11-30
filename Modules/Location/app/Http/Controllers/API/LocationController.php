<?php

namespace Modules\Location\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Location\Http\Resources\AreaResource;
use Modules\Location\Http\Resources\CityResource;
use Modules\Location\Http\Resources\CountryResource;
use Modules\Location\Models\Area;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;

class LocationController extends Controller
{
    /**
     * Get all active countries.
     */
    public function countries(Request $request)
    {
        $countries = Country::where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        return CountryResource::collection($countries);
    }

    /**
     * Get all active cities for a specific country.
     */
    public function cities(Request $request,$countryId)
    {
        $cities = City::where('country_id', $countryId)
            ->where('status', true)
            ->orderBy('order', 'asc')
            ->get();

        return CityResource::collection($cities);
    }

    public function areas(Request $request, $cityId)
    {
        $areas = Area::where('city_id', $cityId)
            ->where('status', true)
            ->orderBy('order', 'asc')
            ->get();
        return AreaResource::collection($areas);
    }
}
