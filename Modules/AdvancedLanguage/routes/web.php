<?php

use Illuminate\Support\Facades\Route;
use Modules\AdvancedLanguage\Http\Controllers\AdvancedLanguageController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('advancedlanguages', AdvancedLanguageController::class)->names('advancedlanguage');
});
