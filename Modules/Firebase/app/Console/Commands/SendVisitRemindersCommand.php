<?php

namespace Modules\Firebase\Console\Commands;

use Illuminate\Console\Command;
use Modules\Booking\Models\Visit;
use Modules\Firebase\Jobs\SendFirebaseNotificationJob;
use Modules\Firebase\Models\FirebaseNotification;
use Carbon\Carbon;

class SendVisitRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:send-visit-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for visits scheduled in 2 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting visit reminder check...');

        $targetDate = Carbon::today()->addDays(2);

        $visits = Visit::whereDate('arrival_time', $targetDate)
            ->where('status', 'pending')
            ->whereHas('patient.patientInfo', function ($query) {
                $query->whereNotNull('fcm_token');
            })
            ->with(['patient'])
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

            // Create a specific notification for this user
            // We create a new notification record for each to keep it personalized and link to specific visit_id
            $notification = FirebaseNotification::create([
                'title' => 'Upcoming Appointment 🗓️',
                'message' => "Reminder: You have an appointment scheduled for " . $visit->arrival_time->format('M d, h:i A') . ". We look forward to seeing you!",
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
