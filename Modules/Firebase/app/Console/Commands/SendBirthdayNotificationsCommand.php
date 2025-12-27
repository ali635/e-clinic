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
        $patients = Patient::whereMonth('date_of_birth', $today->month)
            ->whereDay('date_of_birth', $today->day)
            ->whereHas('patientInfo', function ($query) {
                $query->whereNotNull('fcm_token');
            })
            ->with('patientInfo')
            ->get();

        if ($patients->isEmpty()) {
            $this->info('No patients found with birthday today having FCM tokens.');
            return;
        }

        $this->info("Found {$patients->count()} patients with birthday today.");

        // Group patients by language
        $groupedPatients = $patients->groupBy(function ($patient) {
            return $patient->patientInfo->current_lang ?? config('app.locale');
        });

        $bar = $this->output->createProgressBar($patients->count());
        $bar->start();

        foreach ($groupedPatients as $lang => $group) {
            // Create the notification record for this language group
            $notification = FirebaseNotification::create([
                'title' => setting_lang('birthday_title', null, $lang),
                'message' => setting_lang('birthday_description', null, $lang),
                'screen_event' => 'profile',
                'is_sent' => false,
                'data' => [],
            ]);

            $this->info("Created notification record #{$notification->id} for language: {$lang}. Dispatching jobs...");

            foreach ($group as $patient) {
                SendFirebaseNotificationJob::dispatch($notification, $patient);
                $bar->advance();
            }

            $notification->update(['is_sent' => true]);
        }

        $bar->finish();
        $this->newLine();

        $this->info('All birthday notifications dispatched successfully!');
    }
}
