<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Patient\Http\Resources\DiseaseResource;
use Modules\Patient\Models\Disease;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::get();
        return DiseaseResource::collection($diseases);
    }
}
