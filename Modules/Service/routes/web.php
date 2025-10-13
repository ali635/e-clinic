<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\ServiceController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('services', ServiceController::class)->names('service');
// });


Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{slug}', [ServiceController::class, 'show'])->name('service.show');
});
