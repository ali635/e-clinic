<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Credentials Path
    |--------------------------------------------------------------------------
    |
    | The path to your Firebase service account JSON file.
    | Download this from Firebase Console > Project Settings > Service Accounts
    |
    */
    'credentials_path' => env('FIREBASE_CREDENTIALS_PATH', base_path('firebase-credentials.json')),

    /*
    |--------------------------------------------------------------------------
    | Firebase Database URL
    |--------------------------------------------------------------------------
    |
    | Your Firebase Realtime Database URL (optional).
    | Format: https://your-project-id.firebaseio.com
    |
    */
    'database_url' => env('FIREBASE_DATABASE_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configure default settings for Firebase notifications
    |
    */
    'notifications' => [
        /*
         * Whether to send notifications immediately or queue them
         */
        'queue' => env('FIREBASE_QUEUE_NOTIFICATIONS', true),

        /*
         * Default queue name for notification jobs
         */
        'queue_name' => env('FIREBASE_QUEUE_NAME', 'default'),

        /*
         * Number of retry attempts for failed notifications
         */
        'retry_attempts' => env('FIREBASE_RETRY_ATTEMPTS', 3),

        /*
         * Seconds to wait before retrying a failed notification
         */
        'retry_backoff' => env('FIREBASE_RETRY_BACKOFF', 60),
    ],
];
