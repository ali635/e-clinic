<?php

use Illuminate\Support\Facades\Route;
use Modules\Booking\Http\Controllers\API\BookingController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('bookings', BookingController::class)->names('booking');
// });

Route::middleware(['auth:api'])->prefix('v1/patient')->group(function () {
    Route::get('/visits', [BookingController::class, 'index']);
    Route::get('/visits/{id}', [BookingController::class, 'show']);
    Route::post('/create/visit', [BookingController::class, 'store']);
});
