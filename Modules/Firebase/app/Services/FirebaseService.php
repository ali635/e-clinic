<?php

namespace Modules\Firebase\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        try {
            $credentialsPath = config('firebase.credentials_path');

            if (!file_exists($credentialsPath)) {
                throw new \Exception("Firebase credentials file not found at: {$credentialsPath}");
            }

            $factory = (new Factory)->withServiceAccount($credentialsPath);

            $databaseUrl = config('firebase.database_url');
            if ($databaseUrl) {
                $factory = $factory->withDatabaseUri($databaseUrl);
            }

            $this->messaging = $factory->createMessaging();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a notification to a single FCM token.
     *
     * @param string $fcmToken
     * @param string $title
     * @param string $message
     * @param array $data Additional data payload
     * @return array ['success' => bool, 'error' => string|null]
     */
    public function sendNotification(string $fcmToken, string $title, string $message, array $data = []): array
    {
        try {
            $notification = Notification::create($title, $message);

            $messageBuilder = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification);

            // Add custom data if provided
            if (!empty($data)) {
                $messageBuilder = $messageBuilder->withData($data);
            }

            $this->messaging->send($messageBuilder);

            return [
                'success' => true,
                'error' => null,
            ];
        } catch (MessagingException $e) {
            Log::warning("FCM MessagingException for token {$fcmToken}: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error("Unexpected error sending notification to {$fcmToken}: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send notification with image.
     *
     * @param string $fcmToken
     * @param string $title
     * @param string $message
     * @param string $imageUrl
     * @param array $data
     * @return array
     */
    public function sendNotificationWithImage(
        string $fcmToken,
        string $title,
        string $message,
        string $imageUrl,
        array $data = []
    ): array {
        try {
            $notification = Notification::create($title, $message)
                ->withImageUrl($imageUrl);

            $messageBuilder = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification);

            if (!empty($data)) {
                $messageBuilder = $messageBuilder->withData($data);
            }

            $this->messaging->send($messageBuilder);

            return [
                'success' => true,
                'error' => null,
            ];
        } catch (MessagingException $e) {
            Log::warning("FCM MessagingException with image for token {$fcmToken}: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error("Unexpected error sending notification with image to {$fcmToken}: " . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate if an FCM token is valid.
     *
     * @param string $fcmToken
     * @return bool
     */
    public function validateToken(string $fcmToken): bool
    {
        try {
            // Try to send a dry-run message to validate the token
            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(Notification::create('Test', 'Test'));

            $this->messaging->validate($message);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Send notifications to multiple tokens (batch).
     *
     * @param array $messages Array of messages to send
     * @return array Results of sending each message
     */
    public function sendMultiple(array $messages): array
    {
        try {
            $results = [];

            foreach ($messages as $message) {
                $results[] = $this->messaging->send($message);
            }

            return [
                'success' => true,
                'results' => $results,
                'error' => null,
            ];
        } catch (\Exception $e) {
            Log::error("Error sending multiple notifications: " . $e->getMessage());

            return [
                'success' => false,
                'results' => [],
                'error' => $e->getMessage(),
            ];
        }
    }
}
