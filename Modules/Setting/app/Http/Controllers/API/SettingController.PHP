<?php

namespace Modules\Setting\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Http\Resources\CounterResource;

class SettingController extends Controller
{
    public function counterSetting(Request $request)
    {
        app()->setLocale($request->lang);
        $counters = setting_lang('counter_settings');

        return response()->json([
            'status' => true,
            'message' => 'Counter Section retrieved successfully',
            'data' => CounterResource::collection($counters),
        ]);
    }
}
