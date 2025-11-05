<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Patient\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group([
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'checkLang'],
    'prefix' => app()->getLocale(),

], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
