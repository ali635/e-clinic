<?php

namespace Modules\Booking\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Booking\Models\Visit;

class VisitStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // ----- 1. Total Visits -------------------------------------------------
        $totalVisits = Visit::count();

        // ----- 2. Completed Visits --------------------------------------------
        $completed = Visit::where('is_arrival', true)->count();
        $completedPrev = Visit::where('is_arrival', true)
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $completedDiff = $completed - $completedPrev;
        $completedDiffPct = $completedPrev ? round(($completedDiff / $completedPrev) * 100, 1) : 0;

        // ----- 3. Not Completed Visits ----------------------------------------
        $notCompleted = Visit::where('is_arrival', false)->count();
        $notCompletedPrev = Visit::where('is_arrival', false)
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $notCompletedDiff = $notCompleted - $notCompletedPrev;
        $notCompletedDiffPct = $notCompletedPrev ? round(($notCompletedDiff / $notCompletedPrev) * 100, 1) : 0;

        // ----- 4. Total Price (Completed) -------------------------------------
        $totalPrice = Visit::where('is_arrival', true)->sum('total_price');
        $totalPricePrev = Visit::where('is_arrival', true)
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total_price');
        $priceDiff = $totalPrice - $totalPricePrev;
        $priceDiffPct = $totalPricePrev ? round(($priceDiff / $totalPricePrev) * 100, 1) : 0;

        // ----- Build the stats -------------------------------------------------
        return [
            // 1. Total Visits
            Stat::make(__('Total Visits'), number_format($totalVisits))
                ->description($totalVisits > 0 ? __('No change') : null),

            // 2. Completed Visits
            Stat::make(__('Total Completed Visits'), number_format($completed))
                ->description($completedDiffPct . '% ' . ($completedDiff >= 0 ? __('increase') : __('decrease')))
                ->descriptionIcon(
                    $completedDiff >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                ),

            // 3. Not Completed Visits
            Stat::make(__('Total Not Completed Visits'), number_format($notCompleted))
                ->description(abs($notCompletedDiffPct) . '% ' . ($notCompletedDiff >= 0 ? __('increase') : __('decrease')))
                ->descriptionIcon(
                    $notCompletedDiff >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                ),

            // 4. Total Price Received
            Stat::make(__('Total price Received Visits'), __('IQD ') . number_format($totalPrice, 2))
                ->description($priceDiffPct . '% ' . ($priceDiff >= 0 ? __('increase') : __('decrease')))
                ->descriptionIcon(
                    $priceDiff >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                ),
        ];
    }
}
