<?php

use Illuminate\Support\Facades\Route;
use Modules\Firebase\Http\Controllers\FirebaseController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('firebases', FirebaseController::class)->names('firebase');
});
