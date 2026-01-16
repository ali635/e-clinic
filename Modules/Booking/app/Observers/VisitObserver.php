<?php

namespace Modules\Booking\Observers;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Booking\Models\Visit;
use Modules\Booking\Models\VisitFollow;

class VisitObserver
{
    /**
     * Handle the VisitObserver "created" event.
     */
    public function created(Visit $visit): void
    {

        $admin = User::first();
        Notification::make()
            ->title(__('New Visit from :name', ['name' => $visit->patient ?  ($visit->patient->name ? $visit->patient->name : __('Unknown') ) :  __('Unknown')]))
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
        if ($visit->status == 'complete') {
            $checkFollowVisit = VisitFollow::where('visit_id', $visit->id)->exists();
            if (!$checkFollowVisit) {
                // First follow-up: 10 days after arrival_time
                $visitFollow = new VisitFollow();
                $visitFollow->visit_id = $visit->id;
                $visitFollow->patient_id = $visit->patient_id;
                $visitFollow->date = $visit->arrival_time->addDays(10);
                $visitFollow->save();

                // Second follow-up: 1 month after arrival_time
                $visitFollow = new VisitFollow();
                $visitFollow->visit_id = $visit->id;
                $visitFollow->patient_id = $visit->patient_id;
                $visitFollow->date = $visit->arrival_time->addMonth();
                $visitFollow->save();

                // Third follow-up: 2 months after arrival_time
                $visitFollow = new VisitFollow();
                $visitFollow->visit_id = $visit->id;
                $visitFollow->patient_id = $visit->patient_id;
                $visitFollow->date = $visit->arrival_time->addMonths(2);
                $visitFollow->save();
            }

        }
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
