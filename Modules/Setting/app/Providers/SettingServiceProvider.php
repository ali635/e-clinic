<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\Filament\Pages\AboutSetting;
use Modules\Setting\Filament\Pages\FooterSocialSetting;
use Modules\Setting\Filament\Pages\CounterSettings;
use Modules\Setting\Filament\Pages\GeneralSetting;
use Modules\Setting\Filament\Pages\PrescriptionSetting;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class SettingServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Setting';

    protected string $nameLower = 'setting';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        FilamentSettingsHub::register([
            SettingHold::make()
                ->order(2)
                ->label('Site Counter Settings')
                ->icon('heroicon-o-numbered-list')
                ->route('filament.admin.pages.counter-settings')
                ->page(CounterSettings::class)
                ->description('Counter Section in Home Page')
                ->group('Home Page'),
        ]);
        FilamentSettingsHub::register([
            SettingHold::make()
                ->order(2)
                ->label(__('Footer Social settings'))
                ->icon('heroicon-o-puzzle-piece')
                ->route('filament.admin.pages.footer-social-setting')
                ->page(FooterSocialSetting::class)
                ->description(__('facebook , youtube , x , instagram '))
                ->group('Home Page'),
        ]);
        FilamentSettingsHub::register([
            SettingHold::make()
                ->order(2)
                ->label(__('About Us settings'))
                ->icon('heroicon-o-home')
                ->route('filament.admin.pages.about-setting')
                ->page(AboutSetting::class)
                ->description(__('About Us and Address'))
                ->group('Home Page'),
        ]);
        FilamentSettingsHub::register([
            SettingHold::make()
            ->order(2)
            ->label(__('Genral Settings'))
            ->icon('heroicon-o-cog')
            ->route('filament.admin.pages.general-setting')
            ->page(GeneralSetting::class)
            ->description(__('General Settings'))
            ->group('General'),
        ]);

        FilamentSettingsHub::register([
            SettingHold::make()
            ->order(2)
            ->label(__('Prescription Settings'))
            ->icon('heroicon-o-cog')
            ->route('filament.admin.pages.prescription-setting')
            ->page(PrescriptionSetting::class)
            ->description(__('Prescription Settings'))
            ->group('General'),
        ]);

        

    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace') . '\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
