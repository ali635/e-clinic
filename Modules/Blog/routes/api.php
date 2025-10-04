<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\API\BlogController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('blogs', BlogController::class)->names('blog');
// });

Route::prefix('v1')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', [BlogController::class, 'index']);
    });
});
