<?php

namespace Modules\Booking\Filament\Pages;

use Filament\Pages\Page;
use Carbon\Carbon;
use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;

class PatientReportsPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected string $view = 'booking::filament.pages.patient-reports-page';

    protected static ?string $title = 'Patient Reports';

    public function getTitle(): string|Htmlable
    {
        return __('Patient Reports');
    }

    public static function getNavigationLabel(): string
    {
        return __('Patient Reports');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Reports');
    }

    protected static ?int $navigationSort = 100;

    public ?array $data = [];

    protected function getHeaderWidgets(): array
    {
        return [
            \Modules\Booking\Filament\Widgets\NewVsOldPatientsChart::class,
            \Modules\Booking\Filament\Widgets\VisitsOverTimeChart::class,
            \Modules\Booking\Filament\Widgets\PatientsByCityChart::class,
            \Modules\Booking\Filament\Widgets\PatientsByReferralChart::class,
            \Modules\Booking\Filament\Widgets\DiagnosisDistributionChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \Modules\Booking\Filament\Widgets\PatientReportTableWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return array_merge($this->getHeaderWidgets(), $this->getFooterWidgets());
    }
}
