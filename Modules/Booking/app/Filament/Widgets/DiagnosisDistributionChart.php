<?php

namespace Modules\Booking\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Booking\Services\ReportService;
use Carbon\Carbon;

class DiagnosisDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Top 10 Diagnoses';

    protected static ?int $sort = 5;

    public ?string $filter = 'month';

    protected function getData(): array
    {
        $reportService = new ReportService();
        [$startDate, $endDate] = $this->getDateRange();

        $data = $reportService->getDiagnosisDistribution($startDate, $endDate, 10);

        $labels = [];
        $values = [];
        $colors = [
            'rgb(59, 130, 246)',
            'rgb(16, 185, 129)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
            'rgb(139, 92, 246)',
            'rgb(236, 72, 153)',
            'rgb(20, 184, 166)',
            'rgb(251, 146, 60)',
            'rgb(132, 204, 22)',
            'rgb(168, 85, 247)',
        ];

        foreach ($data as $item) {
            $labels[] = strlen($item['diagnosis']) > 30
                ? substr($item['diagnosis'], 0, 27) . '...'
                : $item['diagnosis'];
            $values[] = $item['count'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Cases',
                    'data' => $values,
                    'backgroundColor' => array_slice($colors, 0, count($values)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
