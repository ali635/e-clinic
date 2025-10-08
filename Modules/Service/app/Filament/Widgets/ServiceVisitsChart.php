<?php

namespace Modules\Service\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Service\Models\Service;
use Modules\Booking\Models\Visit;

class ServiceVisitsChart extends ChartWidget
{
    protected ?string $heading = 'Visits per Service';

    protected function getData(): array
    {
        // Query to get the count of visits per service
        $visitCounts = Visit::selectRaw('service_id, COUNT(*) as visit_count')
            ->groupBy('service_id')
            ->with('service') // Eager load the service relationship
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Visits per Service',
                    'data' => $visitCounts->pluck('visit_count')->toArray(),
                    'backgroundColor' => '#4CAF50', // Green shade for visibility
                    'borderColor' => '#388E3C',
                ],
            ],
            'labels' => $visitCounts->map(function ($record) {
                return $record->service ? $record->service->name : 'Unknown Service';
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}