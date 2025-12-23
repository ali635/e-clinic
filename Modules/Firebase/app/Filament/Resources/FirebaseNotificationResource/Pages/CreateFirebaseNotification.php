<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationResource\Pages;

use Modules\Firebase\Filament\Resources\FirebaseNotificationResource;
use Modules\Firebase\Jobs\SendFirebaseNotificationJob;
use Modules\Patient\Models\Patient;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateFirebaseNotification extends CreateRecord
{
    protected static string $resource = FirebaseNotificationResource::class;

    /**
     * Handle the record creation and notification dispatch.
     */
    protected function afterCreate(): void
    {
        /** @var \Modules\Firebase\Models\FirebaseNotification $notification */
        $notification = $this->record;

        // If send_date is set and in the future, don't send now
        if ($notification->send_date && $notification->send_date->isFuture()) {
            // Notification will be sent by scheduled command
            Notification::make()
                ->title('Notification scheduled successfully!')
                ->success()
                ->send();
            return;
        }

        // Dispatch notification jobs
        if ($notification->patients()->count() === 0) {
            // Send to all patients with FCM tokens
            $patients = Patient::whereHas('patientInfo', function ($query) {
                $query->whereNotNull('fcm_token');
            })->get();

            foreach ($patients as $patient) {
                SendFirebaseNotificationJob::dispatch($notification, $patient);
            }

            Notification::make()
                ->title("Notification dispatched to {$patients->count()} patients!")
                ->success()
                ->send();
        } else {
            // Send to specific patients
            $patients = $notification->patients()
                ->whereHas('patientInfo', function ($query) {
                    $query->whereNotNull('fcm_token');
                })
                ->get();

            foreach ($patients as $patient) {
                SendFirebaseNotificationJob::dispatch($notification, $patient);
            }

            Notification::make()
                ->title("Notification dispatched to {$patients->count()} selected patient(s)!")
                ->success()
                ->send();
        }

        // Mark as sent if not scheduled
        if (!$notification->send_date) {
            $notification->update(['is_sent' => true]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
