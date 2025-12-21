<?php

use Illuminate\Support\Facades\Route;
use Modules\Firebase\Http\Controllers\FirebaseController;
use Modules\Firebase\Http\Controllers\API\PatientDeviceController;

Route::prefix('v1/patient')->middleware(['auth:api'])->group(function () {
    // FCM Token Management
    Route::post('fcm-token/update', [PatientDeviceController::class, 'updateFcmToken']);
    Route::get('fcm-token', [PatientDeviceController::class, 'getFcmToken']);
    Route::delete('fcm-token', [PatientDeviceController::class, 'deleteFcmToken']);
});
