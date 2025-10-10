<?php

use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\AuthController;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('patients', PatientController::class)->names('patient');
});

Route::prefix('patient')->name('patient.')->group(function () {
    Route::middleware('guest:patient')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');

        Route::get('/register', [AuthController::class, 'create'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    });

    Route::middleware('auth:patient')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
