<?php

namespace Modules\AdvancedLanguage\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdvancedLanguage\Models\Language;

class AdvancedLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::get();

        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }

    
}
