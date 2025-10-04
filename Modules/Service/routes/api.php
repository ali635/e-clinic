<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\API\ServiceController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('services', ServiceController::class)->names('service');
// });

Route::prefix('v1')->group(function () {
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::get('/{id}', [ServiceController::class, 'show']);

    });
});
