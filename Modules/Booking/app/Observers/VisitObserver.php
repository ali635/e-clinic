<?php

namespace Modules\Booking\Observers;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Booking\Models\Visit;

class VisitObserver
{
    /**
     * Handle the VisitObserver "created" event.
     */
    public function created(Visit $visit): void
    {

        $admin = User::first();
        Notification::make()
            ->title(__('New Visit from :name', ['name' => $visit->patient->name]))
            ->success()
            ->body(__(':service booked for :time', [
                'service' => $visit->service->name,
                'time' => $visit->arrival_time,
            ]))
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('filament.admin.resources.visits.edit', $visit->id))
                    ->markAsRead(),
            ])
            ->sendToDatabase($admin);
    }

    /**
     * Handle the Visit "updated" event.
     */
    public function updated(Visit $visit): void
    {
    }

    /**
     * Handle the Visit "deleted" event.
     */
    public function deleted(Visit $visit): void
    {
    }

    /**
     * Handle the Visit "restored" event.
     */
    public function restored(Visit $visit): void
    {
    }

    /**
     * Handle the Visit "force deleted" event.
     */
    public function forceDeleted(Visit $visit): void
    {
    }
}
