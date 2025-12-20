<?php

namespace Modules\Room\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Room\Models\Room;
use BackedEnum;

class RoomView extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    protected string $view = 'room::pages.room-view';

    protected static bool $shouldRegisterNavigation = false;

    public ?int $roomId = null;

    public ?Room $room = null;

    public function mount(?int $roomId = null): void
    {
        $this->roomId = $roomId ?? request()->query('roomId');
        $this->room = Room::with(['currentVisit.patient', 'currentVisit.service'])->find($this->roomId);

        if (!$this->room) {
            Notification::make()
                ->title(__('Room not found'))
                ->danger()
                ->send();

            $this->redirect(RoomsDashboard::getUrl());
        }
    }

    public function getTitle(): string|Htmlable
    {
        return $this->room ? $this->room->name : __('Room View');
    }

    public static function getRouteName(?\Filament\Panel $panel = null): string
    {
        return 'filament.admin.pages.room-view';
    }

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null): string
    {
        return route('filament.admin.pages.room-view', $parameters, $isAbsolute);
    }

    public function markAssistantDone(): void
    {
        if ($this->room->doctor_stage !== 'waiting_assistant') {
            Notification::make()
                ->title(__('Invalid action'))
                ->body(__('Room is not waiting for assistant doctor'))
                ->warning()
                ->send();
            return;
        }

        $this->room->update(['doctor_stage' => 'waiting_main']);
        $this->room->refresh();

        Notification::make()
            ->title(__('Assistant doctor finished'))
            ->body(__('Room is now ready for main doctor'))
            ->success()
            ->send();
    }

    public function markMainDone(): void
    {
        if ($this->room->doctor_stage !== 'waiting_main') {
            Notification::make()
                ->title(__('Invalid action'))
                ->body(__('Room is not waiting for main doctor'))
                ->warning()
                ->send();
            return;
        }

        // Complete the visit and free the room
        if ($this->room->currentVisit) {
            $this->room->currentVisit->update(['status' => 'complete']);
        }

        $this->room->update([
            'current_visit_id' => null,
            'doctor_stage' => 'available',
        ]);

        $this->room->refresh();

        Notification::make()
            ->title(__('Main doctor finished'))
            ->body(__('Visit completed, room is now available'))
            ->success()
            ->send();

        $this->redirect(RoomsDashboard::getUrl());
    }
}
