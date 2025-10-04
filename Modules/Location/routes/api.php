<?php

use Illuminate\Support\Facades\Route;
use Modules\Location\Http\Controllers\API\LocationController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('locations', LocationController::class)->names('location');
// });


Route::prefix('v1')->group(function () {
    Route::prefix('countries')->group(function () {
        Route::get('/', [LocationController::class, 'countries']);
        Route::get('/{country}/cities', [LocationController::class, 'cities']);
    });
});
