<?php

namespace Modules\Booking\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Booking\Services\ReportService;
use Carbon\Carbon;

class NewVsOldPatientsChart extends ChartWidget
{
    protected ?string $heading = 'New vs Old Patients';

    protected static ?int $sort = 1;

    public ?string $filter = 'month';

    protected function getData(): array
    {
        $reportService = new ReportService();
        [$startDate, $endDate] = $this->getDateRange();

        $stats = $reportService->getPatientTypeStats($startDate, $endDate);

        return [
            'datasets' => [
                [
                    'label' => 'Patients',
                    'data' => [$stats['new'], $stats['old']],
                    'backgroundColor' => [
                        'rgb(59, 130, 246)', // Blue for new
                        'rgb(16, 185, 129)', // Green for old
                    ],
                ],
            ],
            'labels' => ['New Patients', 'Old Patients'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getDateRange(): array
    {
        return match ($this->filter) {
            'today' => [Carbon::today(), Carbon::now()],
            'week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'year' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            default => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }
}
