<?php

namespace Modules\Slider\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Slider\Http\Resources\SliderResource;
use Modules\Slider\Models\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slider::query();

        // Filter only active sliders
        $query->where('status', true)->orderBy('order', 'asc');

        $sliders = $query->get();

        return SliderResource::collection($sliders);
    }

  
}
