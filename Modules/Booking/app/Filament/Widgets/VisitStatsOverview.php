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
        $completed = Visit::where('is_arrival', true)->where('status', 'complete')->count();
        $completedPrev = Visit::where('is_arrival', true)
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $completedDiff = $completed - $completedPrev;
        $completedDiffPct = $completedPrev ? round(($completedDiff / $completedPrev) * 100, 1) : 0;

        // ----- 3. Not Completed Visits (pending) ----------------------------------------
        $pendingCompleted = Visit::where('is_arrival', false)->where('status', 'pending')->count();
        $pendingCompletedPrev = Visit::where('is_arrival', false)->where('status', 'pending')
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $pendingCompletedDiff = $pendingCompleted - $pendingCompletedPrev;
        $pendingCompletedDiffPct = $pendingCompletedPrev ? round(($pendingCompletedDiff / $pendingCompletedPrev) * 100, 1) : 0;

        // ----- 4. Not Completed Visits (cancalled) ----------------------------------------
        $cancalled = Visit::where('is_arrival', false)->where('status', 'cancelled')->count();
        $cancalledPrev = Visit::where('is_arrival', false)->where('status', 'cancelled')
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $cancalledDiff = $cancalled - $cancalledPrev;
        $cancalledDiffPct = $cancalledPrev ? round(($cancalledDiff / $cancalledPrev) * 100, 1) : 0; 


        // ----- 5. Total Price (Completed) -------------------------------------
        $totalPrice = Visit::where('is_arrival', true)->sum('total_after_discount');
        $totalPricePrev = Visit::where('is_arrival', true)
            ->whereBetween('created_at', [now()->subMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total_after_discount');
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

            // 3. Not Completed (Pending) Visits
            Stat::make(__('Total Not Completed (Pending) Visits'), number_format($pendingCompleted))
                ->description(abs($pendingCompletedDiffPct) . '% ' . ($pendingCompletedDiff >= 0 ? __('increase') : __('decrease')))
                ->descriptionIcon(
                    $pendingCompletedDiff >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                ),

            // 4. Not Completed (Canclled) Visits
             Stat::make(__('Total Not Completed (Canclled) Visits'), number_format($cancalled))
                ->description(abs($cancalledDiffPct) . '% ' . ($cancalledDiff >= 0 ? __('increase') : __('decrease')))
                ->descriptionIcon(
                    $cancalledDiff >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                ),

            // 5. Total Price Received
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
