<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use Modules\AdvancedLanguage\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Slider\Filament\Pages\CounterSettings;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

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
        }

        FilamentSettingsHub::register([
            SettingHold::make()
                ->order(2)
                ->label('Site Counter Settings')
                ->icon('heroicon-o-numbered-list')
                ->route('filament.admin.pages.counter-settings')
                ->page(\Modules\Slider\Filament\Pages\CounterSettings::class)
                ->description('Counter Section in Home Page')
                ->group('Home Page'),
        ]);
    }
}
