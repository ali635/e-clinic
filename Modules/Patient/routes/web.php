<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Patient\Http\Controllers\AuthController;
use Modules\Patient\Http\Controllers\PatientController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('patients', PatientController::class)->names('patient');
// });

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::prefix('patient')->name('patient.')->group(function () {
        Route::middleware('guest:patient')->group(function () {
            Route::get('/login', [AuthController::class, 'index'])->name('login');
            Route::post('/login', [AuthController::class, 'login'])->name('login.post');

            Route::get('/register', [AuthController::class, 'create'])->name('register');
            Route::post('/register', [AuthController::class, 'register'])->name('register.post');
        });

        Route::middleware('auth:patient')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/profile', [PatientController::class, 'index'])->name('profile');
            Route::post('/update/profile', [PatientController::class, 'updateProfile'])->name('update.profile');
            Route::get('/dashboard', [PatientController::class, 'statistical'])->name('dashboard');
            Route::get('/visits', [PatientController::class, 'visits'])->name('visits');
            Route::get('/visits/{id}', [PatientController::class, 'showVisit'])->name('visits.show');
            Route::get('/history', [PatientController::class, 'history'])->name('history');
            Route::get('/feedback', [PatientController::class, 'feedback'])->name('feedback');
        });
    });
});
