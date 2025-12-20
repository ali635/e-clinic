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
                $oldRoom->update(['current_visit_id' => null, 'doctor_stage' => 'available']);
            }
        }

        // Assign visit to room and set to waiting for assistant doctor
        $visit->update(['room_id' => $roomId]);
        $room->update([
            'current_visit_id' => $visitId,
            'doctor_stage' => 'waiting_assistant',
        ]);

        Notification::make()
            ->title(__('Patient assigned to room'))
            ->success()
            ->send();
    }

    public function markAssistantDone(int $roomId): void
    {
        $room = Room::findOrFail($roomId);

        if ($room->doctor_stage !== 'waiting_assistant') {
            Notification::make()
                ->title(__('Invalid action'))
                ->body(__('Room is not waiting for assistant doctor'))
                ->warning()
                ->send();
            return;
        }

        $room->update(['doctor_stage' => 'waiting_main']);

        Notification::make()
            ->title(__('Assistant doctor finished'))
            ->body(__('Room is now ready for main doctor'))
            ->success()
            ->send();
    }

    public function markMainDone(int $roomId): void
    {
        $room = Room::findOrFail($roomId);

        if ($room->doctor_stage !== 'waiting_main') {
            Notification::make()
                ->title(__('Invalid action'))
                ->body(__('Room is not waiting for main doctor'))
                ->warning()
                ->send();
            return;
        }

        // Complete the visit and free the room
        if ($room->currentVisit) {
            $room->currentVisit->update(['status' => 'complete']);
        }

        $room->update([
            'current_visit_id' => null,
            'doctor_stage' => 'available',
        ]);

        Notification::make()
            ->title(__('Main doctor finished'))
            ->body(__('Visit completed, room is now available'))
            ->success()
            ->send();
    }

    // Add this method to your RoomsDashboard class
    public function assignFirstRoom(int $visitId): void
    {
        // Find the first available room
        $room = Room::where('doctor_stage', 'available')
            ->whereNull('current_visit_id')
            ->first();

        if (!$room) {
            Notification::make()
                ->title(__('No available rooms'))
                ->body(__('Please wait for a room to become available.'))
                ->warning()
                ->send();
            return;
        }

        // Assign the visit to the room
        $this->assignVisitToRoom($room->id, $visitId);
    }
}