<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Request;
use Modules\Booking\Filament\Resources\Visits\VisitResource;

use Filament\Notifications\Notification;
use Modules\Booking\Models\VisitWaiting;
use Filament\Actions\Action;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Pre-fill patient_id from query parameter if provided
        if ($patientId = Request::query('patient_id')) {
            $data['patient_id'] = (int) $patientId;
        }

        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            Action::make('saveAndMoveToWaiting')
                ->label(__('Save & Move to Waiting List'))
                ->color('warning')
                ->action('saveAndMoveToWaiting'),
            $this->getCancelFormAction(),
        ];
    }

    public function saveAndMoveToWaiting(): void
    {
        $this->create();

        $visit = $this->record;

        VisitWaiting::create([
            'patient_id' => $visit->patient_id,
            'visit_id' => $visit->id,
            'status' => 'pending',
            'is_arrival' => false,
        ]);

        Notification::make()
            ->title(__('Saved and moved to waiting list'))
            ->success()
            ->send();

        $this->redirect(VisitResource::getUrl('index'));
    }
}

