<?php

namespace Modules\Room\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Booking\Models\Visit;
use Modules\Room\Models\Room;
use BackedEnum;

class RoomsDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected string $view = 'room::pages.rooms-dashboard';

    protected static ?int $navigationSort = 1;

    public function getTitle(): string|Htmlable
    {
        return __('Rooms Dashboard');
    }

    public static function getNavigationLabel(): string
    {
        return __('Rooms Dashboard');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Room Management');
    }

    public function getRooms()
    {
        return Room::with(['currentVisit.patient'])->get();
    }

    public function getPendingVisits()
    {
        return Visit::with('patient')
            ->where('status', 'pending')
            ->where('is_arrival', true)
            ->whereNull('room_id')
            ->get();
    }

    public function assignVisitToRoom(int $roomId, int $visitId): void
    {
        $room = Room::findOrFail($roomId);
        $visit = Visit::findOrFail($visitId);

        // Clear any previous room assignment for this visit
        if ($visit->room_id) {
            $oldRoom = Room::find($visit->room_id);
            if ($oldRoom && $oldRoom->current_visit_id === $visit->id) {
                $oldRoom->update(['current_visit_id' => null, 'is_ready' => true]);
            }
        }

        // Assign visit to room
        $visit->update(['room_id' => $roomId]);
        $room->update([
            'current_visit_id' => $visitId,
            'is_ready' => false,
        ]);

        Notification::make()
            ->title(__('Patient assigned to room'))
            ->success()
            ->send();
    }

    public function markRoomReady(int $roomId): void
    {
        $room = Room::findOrFail($roomId);
        $room->update(['is_ready' => true]);

        Notification::make()
            ->title(__('Room marked as ready'))
            ->success()
            ->send();
    }

    public function markRoomNotReady(int $roomId): void
    {
        $room = Room::findOrFail($roomId);
        $room->update(['is_ready' => false]);

        Notification::make()
            ->title(__('Room marked as not ready'))
            ->warning()
            ->send();
    }

    public function completeVisit(int $roomId): void
    {
        $room = Room::findOrFail($roomId);

        if ($room->currentVisit) {
            $room->currentVisit->update(['status' => 'complete']);
        }

        $room->update([
            'current_visit_id' => null,
            'is_ready' => true,
        ]);

        Notification::make()
            ->title(__('Visit completed, room is now available'))
            ->success()
            ->send();
    }
}
