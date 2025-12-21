<?php

use Illuminate\Support\Facades\Route;
use Modules\Firebase\Http\Controllers\FirebaseController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('firebases', FirebaseController::class)->names('firebase');
});
