<?php

namespace App\Providers\Filament;

use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Enums\AuthLayout;
use Caresome\FilamentAuthDesigner\Enums\MediaDirection;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Coolsam\Modules\ModulesPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Booking\Filament\Widgets\VisitStatsOverview;
use Modules\Patient\Filament\Widgets\Patient;
use Modules\Patient\Filament\Widgets\PatientArea;
use Modules\Patient\Filament\Widgets\PatientDisease;
use Modules\Service\Filament\Widgets\ServiceVisitsChart;
use Resma\FilamentAwinTheme\FilamentAwinTheme;
use TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin;
use Z3d0X\FilamentFabricator\FilamentFabricatorPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin-control')
            ->login()
            ->brandLogo(setting(asset('storage/' . setting('site_logo'))))
            ->brandLogoHeight('4rem')
            ->brandName(setting('site_name'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([

                AccountWidget::class,
                // FilamentInfoWidget::class,
                VisitStatsOverview::class,
                Patient::class,
                PatientArea::class,
                PatientDisease::class,
                ServiceVisitsChart::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                ModulesPlugin::make(),
                FilamentAwinTheme::make(),
                FilamentTranslationsPlugin::make(),
                GlobalSearchModalPlugin::make(),
                AuthDesignerPlugin::make()
                ->login(
                    layout: AuthLayout::Split,
                    media: asset('images/intro-image.jpg'),
                    direction: MediaDirection::Right
                ),
                \TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin::make()
                    ->allowSiteSettings()
                    ->allowSocialMenuSettings(false),
                // \TomatoPHP\FilamentTranslationsGoogle\FilamentTranslationsGooglePlugin::make()
                // FilamentFabricatorPlugin::make(),
            ])
            ->databaseNotifications()
            ->topNavigation(false)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
