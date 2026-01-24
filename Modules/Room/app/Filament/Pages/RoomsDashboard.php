<?php

namespace Modules\Room\Filament\Pages;

use App\Services\GeminiAIService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Models\Visit;
use Modules\Booking\Models\VisitWaiting;
use Modules\Room\Models\Room;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Radio;
use BackedEnum;

class RoomsDashboard extends Page implements HasActions
{
    use InteractsWithActions;
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

    public function getVisitWaitings()
    {
        return VisitWaiting::with(['patient', 'visit'])
            ->where('status', 'pending')
            ->where('is_arrival', true)
            ->whereNull('room_id')
            ->get();
    }

    public function assignVisitToRoom(int $roomId, int $visitId, ?int $waitingId = null): void
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

        // If it was from waiting list, mark it as complete in the waiting list
        if ($waitingId) {
            VisitWaiting::find($waitingId)?->update(['status' => 'complete']);
        }

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

    public function completeVisitAction(): Action
    {
        return Action::make('completeVisit')
            ->form([
                Radio::make('completion_type')
                    ->label(__('Completion Status'))
                    ->options([
                        'complete' => __('Complete Visit'),
                        'move_to_waiting' => __('Complete and Move to Waiting List'),
                    ])
                    ->default('complete')
                    ->required(),
            ])
            ->action(function (array $data, array $arguments) {
                $roomId = $arguments['roomId'];
                $room = Room::findOrFail($roomId);
                $visit = $room->currentVisit;

                if (!$visit) {
                    Notification::make()->title(__('No visit found'))->danger()->send();
                    return;
                }

                // AI Processing Logic (moved from markMainDone)
                try {
                    if (empty($visit->result_ai) || $visit->result_ai == '<p></p>') {
                        $geminiService = new GeminiAIService();
                        $aiResult = $geminiService->analyzeVisit($visit);
                        if ($aiResult) {
                            $visit->update(['result_ai' => $aiResult]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('AI analysis failed', ['error' => $e->getMessage()]);
                }

                $visit->update(['status' => 'complete']);

                if ($data['completion_type'] === 'move_to_waiting') {
                    VisitWaiting::create([
                        'patient_id' => $visit->patient_id,
                        'visit_id' => $visit->id,
                        'status' => 'pending',
                        'is_arrival' => false,
                    ]);
                }

                $room->update([
                    'current_visit_id' => null,
                    'doctor_stage' => 'available',
                ]);

                Notification::make()
                    ->title(__('Main doctor finished'))
                    ->body($data['completion_type'] === 'move_to_waiting'
                        ? __('Visit completed and added to waiting list')
                        : __('Visit completed, room is now available'))
                    ->success()
                    ->send();
            });
    }

    public function markMainDone(int $roomId): void
    {
        // This is now handled by completeVisitAction
        // But we keep the method as a fallback or if triggered differently
        $this->replaceMarkMainDoneWithAction($roomId);
    }

    protected function replaceMarkMainDoneWithAction(int $roomId): void
    {
        Notification::make()
            ->title(__('Please use the action button'))
            ->warning()
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