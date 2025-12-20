<?php

namespace Modules\Booking\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Booking\Services\ReportService;
use Carbon\Carbon;

class VisitsOverTimeChart extends ChartWidget
{
    protected ?string $heading = 'Visits Over Time';

    protected static ?int $sort = 2;

    public ?string $filter = 'month';

    protected function getData(): array
    {
        $reportService = new ReportService();
        [$startDate, $endDate] = $this->getDateRange();

        $groupBy = $reportService->determineTimeGrouping($startDate, $endDate);
        $data = $reportService->getVisitsOverTime($startDate, $endDate, $groupBy);

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            if ($groupBy === 'day') {
                $labels[] = Carbon::parse($item->date)->format('M d');
            } elseif ($groupBy === 'week') {
                $labels[] = 'Week ' . substr($item->week, -2);
            } elseif ($groupBy === 'month') {
                $labels[] = Carbon::parse($item->month . '-01')->format('M Y');
            } else {
                $labels[] = $item->year;
            }
            $values[] = $item->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Visits',
                    'data' => $values,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
