<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\API\SettingController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('settings', SettingController::class)->names('setting');
// });


Route::prefix('v1')->group(function () {
    Route::get('counter-settings', [SettingController::class, 'counterSetting']);
});

