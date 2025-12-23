<?php

namespace Modules\Firebase\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Firebase\Models\FirebaseNotification;
use Modules\Firebase\Models\FirebaseNotificationLog;
use Modules\Firebase\Services\FirebaseService;
use Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\Log;

class SendFirebaseNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public FirebaseNotification $notification,
        public Patient $patient
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(FirebaseService $firebaseService): void
    {
        // Check if patient has FCM token
        $patientInfo = $this->patient->patientInfo;

        if (!$patientInfo || !$patientInfo->fcm_token) {
            Log::warning("Patient {$this->patient->id} does not have FCM token");

            $this->createLog(false, 'Patient does not have FCM token');
            return;
        }

        $fcmToken = $patientInfo->fcm_token;

        // Prepare notification data
        $data = $this->notification->data ?? [];

        if ($this->notification->screen_event) {
            $data['screen'] = $this->notification->screen_event;
        }

        // Add notification ID for tracking
        $data['notification_id'] = (string) $this->notification->id;

        // Ensure dependent IDs are passed as top-level keys if needed, or keep them in data
        // For example if visit_details expects visit_id at top level of data:
        if (isset($data['visit_id'])) {
            $data['id'] = (string) $data['visit_id'];
        }
        if (isset($data['post_id'])) {
            $data['id'] = (string) $data['post_id'];
        }
        if (isset($data['service_id'])) {
            $data['id'] = (string) $data['service_id'];
        }

        try {
            // Send notification with or without image
            if ($this->notification->image) {
                $imageUrl = url('storage/' . $this->notification->image);

                $result = $firebaseService->sendNotificationWithImage(
                    $fcmToken,
                    $this->notification->title,
                    $this->notification->message,
                    $imageUrl,
                    $data
                );
            } else {
                $result = $firebaseService->sendNotification(
                    $fcmToken,
                    $this->notification->title,
                    $this->notification->message,
                    $data
                );
            }

            // Create log entry
            $this->createLog($result['success'], $result['error']);

            if ($result['success']) {
                Log::info("Successfully sent notification {$this->notification->id} to patient {$this->patient->id}");
            } else {
                Log::warning("Failed to send notification {$this->notification->id} to patient {$this->patient->id}: {$result['error']}");
            }
        } catch (\Exception $e) {
            Log::error("Exception sending notification {$this->notification->id} to patient {$this->patient->id}: " . $e->getMessage());

            $this->createLog(false, $e->getMessage());

            // Continue processing other notifications instead of failing the job
        }
    }

    /**
     * Create a log entry for this notification attempt.
     */
    protected function createLog(bool $success, ?string $error = null): void
    {
        FirebaseNotificationLog::create([
            'patient_id' => $this->patient->id,
            'firebase_notification_id' => $this->notification->id,
            'is_sent' => $success,
            'error_exceptions' => $error,
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Job failed for notification {$this->notification->id} to patient {$this->patient->id}: " . $exception->getMessage());

        $this->createLog(false, "Job failed after {$this->tries} attempts: " . $exception->getMessage());
    }
}
