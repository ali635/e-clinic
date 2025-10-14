<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Service\Http\Controllers\ServiceController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('services', ServiceController::class)->names('service');
// });


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('services');
        Route::get('/{slug}', [ServiceController::class, 'show'])->name('service.show');
    });
});
