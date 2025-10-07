<?php

use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\API\AuthController;
use Modules\Patient\Http\Controllers\API\DiseaseController;
use Modules\Patient\Http\Controllers\API\FeedbackController;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('patients', PatientController::class)->names('patient');
});

Route::prefix('v1')->group(function () {
    Route::prefix('patient')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });
    Route::prefix('diseases')->group(function () {
        Route::get('/', [DiseaseController::class, 'index']);
    });
    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('patient/feedback')->group(function () {
            Route::get('/', [FeedbackController::class, 'index']);
            Route::post('store', [FeedbackController::class, 'store']);
        });
    });
});
