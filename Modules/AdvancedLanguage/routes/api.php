<?php

use Illuminate\Support\Facades\Route;
use Modules\AdvancedLanguage\Http\Controllers\API\AdvancedLanguageController;

// use Modules\AdvancedLanguage\Http\Controllers\AdvancedLanguageController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('advancedlanguages', AdvancedLanguageController::class)->names('advancedlanguage');
// });

Route::prefix('v1')->group(function () {
    Route::get('/languages', [AdvancedLanguageController::class, 'index']);
});
