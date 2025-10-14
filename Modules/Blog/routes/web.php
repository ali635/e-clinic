<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Blog\Http\Controllers\BlogController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('blogs', BlogController::class)->names('blog');
// });

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/{slug}', [BlogController::class, 'show'])->name('post.show');
    });
});
