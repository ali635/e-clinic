# Firebase Push Notification System - Setup Instructions

## Overview

This guide will help you set up the Firebase Cloud Messaging (FCM) push notification system for the e-clinic mobile app.

## Prerequisites

-   Firebase project created in [Firebase Console](https://console.firebase.google.com/)
-   Service account JSON credentials downloaded
-   `kreait/firebase-php` package installed

## Installation Steps

### 1. Install Firebase PHP SDK

The `kreait/firebase-php` package is required. Install it via Composer:

```bash
composer require kreait/firebase-php
```

### 2. Generate Service Account Credentials

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project
3. Click the gear icon → **Project Settings**
4. Navigate to **Service Accounts** tab
5. Click **Generate New Private Key**
6. Save the downloaded JSON file as `firebase-credentials.json` in your project root

### 3. Configure Environment Variables

Update your `.env` file with the following configuration:

```env
# Firebase Cloud Messaging Configuration
FIREBASE_CREDENTIALS_PATH="${base_path}/firebase-credentials.json"
FIREBASE_DATABASE_URL=https://your-project-id.firebaseio.com
FIREBASE_QUEUE_NOTIFICATIONS=true
FIREBASE_QUEUE_NAME=default
FIREBASE_RETRY_ATTEMPTS=3
FIREBASE_RETRY_BACKOFF=60
```

Replace `your-project-id` with your actual Firebase project ID.

### 4. Run Migrations

Execute the database migrations to create the required tables:

```bash
php artisan migrate
```

This will create the following tables:

-   `patient_info` - Stores FCM tokens and device information
-   `firebase_notifications` - Main notifications table
-   `firebase_notification_patient` - Pivot table for patient targeting
-   `firebase_notification_logs` - Notification delivery logs

### 5. Create Storage Directory

Create the storage directory for notification images:

```bash
php artisan storage:link
```

### 6. Start Queue Worker

Since notifications are dispatched via Laravel queues, ensure a queue worker is running:

```bash
php artisan queue:work
```

For production, set up Supervisor to keep the queue worker running.

### 7. Schedule Notifications Command

The scheduled notifications command runs automatically every minute via the service provider.

To test it manually:

```bash
php artisan firebase:schedule-notifications
```

## Usage

### Sending Notifications via Admin Panel

1. Navigate to **Firebase → Firebase Notifications** in the Filament admin panel
2. Click **Create**
3. Fill in the notification details:
    - **Title**: Notification title (required)
    - **Message**: Notification message (required)
    - **Image**: Optional image to display
    - **Screen Event**: Optional deep link/screen identifier (e.g., `visit_details`, `profile`)
    - **Send Date**: Optional - schedule for future, or leave empty to send immediately
    - **Patients**: Optional - select specific patients, or leave empty to send to ALL patients
4. Click **Save**

### Notification Behavior

-   **Immediate Send**: If no send date is set, the notification is dispatched immediately to the queue
-   **Scheduled Send**: If a send date is set, the notification will be sent when the scheduled time arrives
-   **All Patients**: If no patients are selected, the notification is sent to ALL patients with FCM tokens
-   **Specific Patients**: If patients are selected, only those patients receive the notification

### Viewing Notification Logs

1. Open a notification in the admin panel
2. Scroll to the **Notification Logs** section
3. View delivery status for each patient:
    - ✅ **Sent**: Successfully delivered
    - ❌ **Failed**: Delivery failed (hover over error to see details)

## Mobile App Integration

### Storing FCM Tokens

When a patient logs into the mobile app, store their FCM token via API:

```php
// Example API endpoint
POST /api/patient/update-fcm-token

{
    "fcm_token": "patient-device-fcm-token",
    "current_lang": "en",
    "device_info": {
        "platform": "android",
        "version": "11",
        "model": "Pixel 5"
    }
}
```

Example controller implementation:

```php
public function updateFcmToken(Request $request)
{
    $patient = auth()->user(); // Patient

    $patient->patientInfo()->updateOrCreate(
        ['patient_id' => $patient->id],
        [
            'fcm_token' => $request->fcm_token,
            'current_lang' => $request->current_lang,
            'device_info' => $request->device_info,
        ]
    );

    return response()->json(['message' => 'FCM token updated successfully']);
}
```

### Handling Notifications in Mobile App

When receiving a notification, check the `screen_event` data field to determine which screen to open:

```javascript
// React Native example
messaging().onMessage(async (remoteMessage) => {
    const { screen_event } = remoteMessage.data;

    if (screen_event === "visit_details") {
        navigation.navigate("VisitDetails");
    } else if (screen_event === "profile") {
        navigation.navigate("Profile");
    }
});
```

## Troubleshooting

### Notifications Not Sending

1. **Check queue worker**: Ensure `php artisan queue:work` is running
2. **Check FCM tokens**: Verify patients have valid FCM tokens in `patient_info` table
3. **Check Firebase credentials**: Ensure `firebase-credentials.json` exists and is valid
4. **Check logs**: Review Laravel logs for errors: `storage/logs/laravel.log`

### Invalid FCM Tokens

If a patient's FCM token is invalid or expired:

-   The notification will fail
-   An error will be logged in `firebase_notification_logs`
-   The mobile app should refresh the FCM token and send it to the API

### Scheduled Notifications Not Running

1. Ensure the Laravel scheduler is running:

    ```bash
    php artisan schedule:work  # For local development
    ```

2. For production, add to crontab:
    ```bash
    * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
    ```

## Security Considerations

-   **Never commit** `firebase-credentials.json` to version control
-   Add it to `.gitignore`:
    ```
    firebase-credentials.json
    ```
-   Store credentials securely in production (e.g., environment variables, secrets manager)
-   Use HTTPS for image URLs in notifications

## API Reference

### FirebaseService Methods

```php
// Send basic notification
$firebaseService->sendNotification(
    fcmToken: 'token',
    title: 'Test',
    message: 'Message',
    data: ['screen' => 'home']
);

// Send notification with image
$firebaseService->sendNotificationWithImage(
    fcmToken: 'token',
    title: 'Test',
    message: 'Message',
    imageUrl: 'https://example.com/image.jpg',
    data: []
);

// Validate FCM token
$isValid = $firebaseService->validateToken('token');
```

## Support

For issues or questions:

1. Check the notification logs in the admin panel
2. Review Laravel logs in `storage/logs/`
3. Verify Firebase credentials and configuration
4. Ensure queue workers are running
