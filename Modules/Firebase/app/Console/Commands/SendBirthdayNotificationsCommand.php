<?php

namespace Modules\Firebase\Console\Commands;

use Illuminate\Console\Command;
use Modules\Firebase\Jobs\SendFirebaseNotificationJob;
use Modules\Firebase\Models\FirebaseNotification;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;

class SendBirthdayNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:send-birthday-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Happy Birthday notifications to patients born today.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting birthday notification check...');

        $today = Carbon::today();

        // Find patients whose birthday is today (month and day match)
        // Note: date_of_birth is a date field, so we compare month and day
        $patients = Patient::whereMonth('date_of_birth', $today->month)
            ->whereDay('date_of_birth', $today->day)
            ->whereHas('patientInfo', function ($query) {
                $query->whereNotNull('fcm_token');
            })
            ->get();

        if ($patients->isEmpty()) {
            $this->info('No patients found with birthday today having FCM tokens.');
            return;
        }

        $this->info("Found {$patients->count()} patients with birthday today.");

        // Create the notification record
        $notification = FirebaseNotification::create([
            'title' => 'Happy Birthday! 🎂',
            'message' => 'We wish you a wonderful birthday filled with joy and happiness from Dr Azad Clinic!',
            'screen_event' => 'profile',
            'is_sent' => false, // Will be marked sent/logged via job? Actually job marks log, parent notification status usually reflects bulk. 
            // Reuse existing flow: One notification record sent to many people. 
            // Ideally we create one "Campaign" notification.
            'data' => [],
        ]);

        $this->info("Created notification record #{$notification->id}. Dispatching jobs...");

        $bar = $this->output->createProgressBar($patients->count());
        $bar->start();

        foreach ($patients as $patient) {
            SendFirebaseNotificationJob::dispatch($notification, $patient);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $notification->update(['is_sent' => true]);

        $this->info('All birthday notifications dispatched successfully!');
    }
}
