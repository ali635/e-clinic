# Firebase API Documentation

## Patient Device FCM Token Management

### Base URL

```
/api/v1/patient
```

### Authentication

All endpoints require Bearer token authentication using Laravel Passport (`auth:api` middleware).

---

## Endpoints

### 1. Update FCM Token

Update or create patient FCM token and device information.

**Endpoint:** `POST /api/v1/patient/fcm-token/update`

**Headers:**

```
Authorization: Bearer {access_token}
Content-Type: application/json
```

**Request Body:**

```json
{
    "fcm_token": "dXB3ZW1pOjE3MzQ4MjQzOTk2MjU6YW5kcm9pZDplYzU3ZWM...",
    "current_lang": "en",
    "device_info": {
        "platform": "android",
        "version": "13",
        "model": "Pixel 7",
        "app_version": "1.0.0"
    }
}
```

**Request Fields:**

-   `fcm_token` (required, string) - Firebase Cloud Messaging token
-   `current_lang` (optional, string, max 10 chars) - User's preferred language (e.g., "en", "ar")
-   `device_info` (optional, object) - Device information
    -   `platform` (optional, string) - OS platform (e.g., "android", "ios")
    -   `version` (optional, string) - OS version
    -   `model` (optional, string) - Device model
    -   `app_version` (optional, string) - App version

**Success Response (200):**

```json
{
    "success": true,
    "message": "FCM token and device information updated successfully",
    "data": {
        "patient_id": 1,
        "fcm_token": "dXB3ZW1pOjE3MzQ4MjQzOTk2MjU6YW5kcm9pZDplYzU3ZWM...",
        "current_lang": "en",
        "device_info": {
            "platform": "android",
            "version": "13",
            "model": "Pixel 7",
            "app_version": "1.0.0"
        }
    }
}
```

**Error Response (422 - Validation Failed):**

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "fcm_token": ["The fcm token field is required."]
    }
}
```

**Error Response (401 - Unauthorized):**

```json
{
    "success": false,
    "message": "Unauthorized. Please login first."
}
```

---

### 2. Get FCM Token

Retrieve current patient's FCM token and device information.

**Endpoint:** `GET /api/v1/patient/fcm-token`

**Headers:**

```
Authorization: Bearer {access_token}
```

**Success Response (200):**

```json
{
    "success": true,
    "message": "Device information retrieved successfully",
    "data": {
        "patient_id": 1,
        "fcm_token": "dXB3ZW1pOjE3MzQ4MjQzOTk2MjU6YW5kcm9pZDplYzU3ZWM...",
        "current_lang": "en",
        "device_info": {
            "platform": "android",
            "version": "13",
            "model": "Pixel 7",
            "app_version": "1.0.0"
        }
    }
}
```

**Success Response (200 - No Data):**

```json
{
    "success": true,
    "message": "No device information found",
    "data": null
}
```

---

### 3. Delete FCM Token

Remove patient's FCM token (useful for logout). Device info is preserved.

**Endpoint:** `DELETE /api/v1/patient/fcm-token`

**Headers:**

```
Authorization: Bearer {access_token}
```

**Success Response (200):**

```json
{
    "success": true,
    "message": "FCM token removed successfully"
}
```

---

## Usage Examples

### React Native / Expo

```javascript
import messaging from "@react-native-firebase/messaging";
import AsyncStorage from "@react-native-async-storage/async-storage";
import { Platform } from "react-native";
import DeviceInfo from "react-native-device-info";

// Get FCM token and send to API
async function updateFcmToken() {
    try {
        // Request permission (iOS)
        await messaging().requestPermission();

        // Get FCM token
        const fcmToken = await messaging().getToken();

        // Get device info
        const deviceInfo = {
            platform: Platform.OS,
            version: Platform.Version,
            model: await DeviceInfo.getModel(),
            app_version: DeviceInfo.getVersion(),
        };

        // Get access token
        const accessToken = await AsyncStorage.getItem("access_token");

        // Send to API
        const response = await fetch(
            "https://your-api.com/api/v1/patient/fcm-token/update",
            {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${accessToken}`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    fcm_token: fcmToken,
                    current_lang: "en", // or get from app language settings
                    device_info: deviceInfo,
                }),
            }
        );

        const data = await response.json();
        console.log("FCM token updated:", data);
    } catch (error) {
        console.error("Error updating FCM token:", error);
    }
}

// Call on app launch and login
updateFcmToken();
```

### Flutter

```dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:device_info_plus/device_info_plus.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'dart:io';

Future<void> updateFcmToken(String accessToken) async {
  try {
    // Get FCM token
    final fcmToken = await FirebaseMessaging.instance.getToken();

    // Get device info
    final deviceInfo = DeviceInfoPlugin();
    Map<String, dynamic> deviceData;

    if (Platform.isAndroid) {
      final androidInfo = await deviceInfo.androidInfo;
      deviceData = {
        'platform': 'android',
        'version': androidInfo.version.release,
        'model': androidInfo.model,
        'app_version': '1.0.0', // Get from package info
      };
    } else if (Platform.isIOS) {
      final iosInfo = await deviceInfo.iosInfo;
      deviceData = {
        'platform': 'ios',
        'version': iosInfo.systemVersion,
        'model': iosInfo.model,
        'app_version': '1.0.0',
      };
    }

    // Send to API
    final response = await http.post(
      Uri.parse('https://your-api.com/api/v1/patient/fcm-token/update'),
      headers: {
        'Authorization': 'Bearer $accessToken',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'fcm_token': fcmToken,
        'current_lang': 'en',
        'device_info': deviceData,
      }),
    );

    if (response.statusCode == 200) {
      print('FCM token updated successfully');
    }
  } catch (e) {
    print('Error updating FCM token: $e');
  }
}
```

---

## Best Practices

1. **Update on Login**: Always update FCM token after successful login
2. **Update on App Launch**: Check and update token when app starts
3. **Handle Token Refresh**: Listen to FCM token refresh events and update
4. **Logout**: Delete FCM token when user logs out to stop receiving notifications
5. **Error Handling**: Implement retry logic for failed updates
6. **Language Update**: Update `current_lang` when user changes app language

---

## Integration Workflow

```
1. User logs in → Get FCM token → Send to API
2. App launches → Check if token changed → Update if needed
3. User logs out → Delete FCM token from server
4. Token refreshes → Update new token
5. Language changes → Update current_lang
```
