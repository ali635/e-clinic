<?php

namespace Modules\Firebase\Console\Commands;

use Illuminate\Console\Command;
use Modules\Booking\Models\Visit;
use Modules\Firebase\Jobs\SendFirebaseNotificationJob;
use Modules\Firebase\Models\FirebaseNotification;
use Carbon\Carbon;

class SendNextVisitRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:send-next-visit-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for next visits scheduled in 2 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting next visit reminder check...');

        $targetDate = Carbon::today()->addDays(2);

        $visits = Visit::where('status', 'complete')
            ->where('is_arrival', true)
            ->where('next_visit', '!=', null)
            ->whereDate('next_visit', $targetDate)
            ->whereHas('patient.patientInfo', function ($query) {
                $query->whereNotNull('fcm_token');
            })
            ->with(['patient', 'patient.patientInfo'])
            ->get();

        if ($visits->isEmpty()) {
            $this->info("No pending visits found for {$targetDate->toDateString()} with valid tokens.");
            return;
        }

        $this->info("Found {$visits->count()} visits for {$targetDate->toDateString()}.");

        $bar = $this->output->createProgressBar($visits->count());
        $bar->start();

        foreach ($visits as $visit) {
            $patient = $visit->patient;
            $currentLanguage = $patient->patientInfo->current_lang ?? config('app.locale');
            // Create a specific notification for this user
            // We create a new notification record for each to keep it personalized and link to specific visit_id
            $notification = FirebaseNotification::create([
                'title' => setting_lang('visit_reminder_title', null, $currentLanguage),
                'message' => setting_lang('visit_reminder_description', null, $currentLanguage) . ' ' . $visit->arrival_time->format('M d, h:i A'),
                'screen_event' => 'visit_details',
                'data' => ['visit_id' => $visit->id],
                'is_sent' => false,
            ]);

            // Dispatch job
            SendFirebaseNotificationJob::dispatch($notification, $patient);

            // Mark as sent
            $notification->update(['is_sent' => true]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All visit reminders dispatched successfully!');
    }
}
