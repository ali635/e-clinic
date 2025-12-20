<?php

namespace Modules\Room\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Booking\Models\Visit;
use Modules\Room\Models\Room;

class RoomStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('is_ready', true)->count();
        $pendingVisits = Visit::where('status', 'arrived')->count();
        $activePatients = Visit::where('status', 'in_progress')->count();

        return [
            Stat::make(__('Available Rooms'), "{$availableRooms}/{$totalRooms}")
                ->icon('heroicon-o-building-office-2')
                ->color($availableRooms > 0 ? 'success' : 'warning')
                ->description(__('Rooms ready for patients')),
                
            Stat::make(__('Pending Visits'), $pendingVisits)
                ->icon('heroicon-o-clock')
                ->color($pendingVisits > 0 ? 'warning' : 'success')
                ->description(__('Patients waiting for rooms')),
                
            Stat::make(__('Active Patients'), $activePatients)
                ->icon('heroicon-o-user-group')
                ->color('primary')
                ->description(__('Currently in rooms')),
        ];
    }
    
    public static function canView(): bool
    {
        return true;
    }
}
