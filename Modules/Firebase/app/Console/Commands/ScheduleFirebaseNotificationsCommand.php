<?php

namespace Modules\Firebase\Console\Commands;

use Illuminate\Console\Command;
use Modules\Firebase\Models\FirebaseNotification;
use Modules\Firebase\Jobs\SendFirebaseNotificationJob;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;

class ScheduleFirebaseNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:schedule-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled Firebase notifications and dispatch them to patients';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for scheduled Firebase notifications...');

        // Get all notifications that are scheduled and not yet sent
        $notifications = FirebaseNotification::where('is_sent', false)
            ->whereNotNull('send_date')
            ->where('send_date', '<=', Carbon::now())
            ->get();

        if ($notifications->isEmpty()) {
            $this->info('No scheduled notifications to send.');
            return self::SUCCESS;
        }

        $this->info("Found {$notifications->count()} notification(s) to send.");

        foreach ($notifications as $notification) {
            $this->info("Processing notification #{$notification->id}: {$notification->title}");

            // Check if notification is for all patients
            if ($notification->patients()->count() === 0) {
                // Send to all patients
                $patients = Patient::whereHas('patientInfo', function ($query) {
                    $query->whereNotNull('fcm_token');
                })->get();

                $this->info("  Sending to all patients with FCM tokens ({$patients->count()} patients)");

                foreach ($patients as $patient) {
                    SendFirebaseNotificationJob::dispatch($notification, $patient);
                }
            } else {
                // Send to specific patients
                $patients = $notification->patients()
                    ->whereHas('patientInfo', function ($query) {
                        $query->whereNotNull('fcm_token');
                    })
                    ->get();

                $this->info("  Sending to {$patients->count()} specific patient(s)");

                foreach ($patients as $patient) {
                    SendFirebaseNotificationJob::dispatch($notification, $patient);
                }
            }

            // Mark as sent
            $notification->update(['is_sent' => true]);

            $this->info("  ✓ Notification #{$notification->id} dispatched successfully");
        }

        $this->info('All scheduled notifications have been dispatched!');

        return self::SUCCESS;
    }
}
