<?php

use Modules\AdvancedLanguage\Models\Language;

if (!function_exists('getDirection')) {
    /**
     * Get direction (ltr/rtl) for the given locale code.
     *
     * @param string|null $locale
     * @return string
     */
    function getDirection(?string $locale = null): string
    {
        // Use current app locale if none provided
        $locale = $locale ?? app()->getLocale();

        // Fetch from database
        $lang = Language::where('lang_code', $locale)->first();

        // Return its direction or default to 'ltr'
        return $lang?->dir ?? 'ltr';
    }
    
}
