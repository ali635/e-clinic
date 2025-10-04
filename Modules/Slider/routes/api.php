<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\Http\Controllers\API\SliderController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('sliders', SliderController::class)->names('slider');
// });


Route::prefix('v1')->group(function () {
    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index']);
    });
});

