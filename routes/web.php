<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Patient\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });
// dd(app()->getLocale());
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'checkLang'],

], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
    Route::get('/linkstorage', function () {
        Artisan::call('storage:unlink');
        return 'Storage link created';
    });
});
