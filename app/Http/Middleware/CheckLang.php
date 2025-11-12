<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdvancedLanguage\Models\Language;

class CheckLang
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // check language is exist in model lange or not

        $default_lang = Language::query()->where('lang_code', app()->getLocale())->first();

        if (!$default_lang) {
            $default_lang = Language::query()->where('is_default', true)->first();
        }
        
        if ($default_lang) {
            app()->setLocale($default_lang->lang_code,);
        } else {
            app()->setLocale('en');
        }   
        return $next($request);
    }
}
