<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use Modules\AdvancedLanguage\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       
        if (Schema::hasTable('languages')) {

            $locales_translations = Language::get()
                ->mapWithKeys(function ($locale) {
                    return [
                        $locale->lang_code => [
                            'label' => $locale->lang_name,
                            'flag' => $locale->lang_flag,
                        ],
                    ];
                })
                ->toArray();


            // Override the filament-translations.locals config
            Config::set('filament-translations.locals', $locales_translations);

            $locales = Language::query()->pluck('lang_code')->toArray();
            // dd($locales);
            LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($locales) {
                $switch->locales($locales);
            });

            $default_lang = Language::query()->where('is_default', true)->first();
            if ($default_lang) {
                Config::set('app.locale', $default_lang->lang_code);
                Config::set('app.direction', $default_lang->dir ?? 'ltr');

            }
        }
       
    }
}
