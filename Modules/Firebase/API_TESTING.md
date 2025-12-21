# Firebase API Testing Examples

## Testing with Postman/Insomnia

### 1. Update FCM Token

**Method:** POST  
**URL:** `http://localhost:8000/api/v1/patient/fcm-token/update`

**Headers:**

```
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**

```json
{
    "fcm_token": "dXB3ZW1pOjE3MzQ4MjQzOTk2MjU6YW5kcm9pZDplYzU3ZWMzZGFjNDRhZGZlOmNvbS5leGFtcGxlLmFwcA",
    "current_lang": "en",
    "device_info": {
        "platform": "android",
        "version": "13",
        "model": "Pixel 7 Pro",
        "app_version": "1.0.0"
    }
}
```

---

### 2. Get FCM Token

**Method:** GET  
**URL:** `http://localhost:8000/api/v1/patient/fcm-token`

**Headers:**

```
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
Accept: application/json
```

---

### 3. Delete FCM Token (Logout)

**Method:** DELETE  
**URL:** `http://localhost:8000/api/v1/patient/fcm-token`

**Headers:**

```
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
Accept: application/json
```

---

## Testing with cURL

### Update FCM Token

```bash
curl -X POST http://localhost:8000/api/v1/patient/fcm-token/update \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "fcm_token": "dXB3ZW1pOjE3MzQ4MjQzOTk2MjU6YW5kcm9pZDplYzU3ZWM",
    "current_lang": "en",
    "device_info": {
      "platform": "android",
      "version": "13",
      "model": "Pixel 7",
      "app_version": "1.0.0"
    }
  }'
```

### Get FCM Token

```bash
curl -X GET http://localhost:8000/api/v1/patient/fcm-token \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Accept: application/json"
```

### Delete FCM Token

```bash
curl -X DELETE http://localhost:8000/api/v1/patient/fcm-token \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Accept: application/json"
```

---

## Testing with PHP (Laravel Tinker)

```php
// In Laravel Tinker
php artisan tinker

// Get a patient
$patient = \Modules\Patient\Models\Patient::first();

// Create or update FCM token
$patientInfo = \Modules\Firebase\Models\PatientInfo::updateOrCreate(
    ['patient_id' => $patient->id],
    [
        'fcm_token' => 'test-fcm-token-123',
        'current_lang' => 'en',
        'device_info' => [
            'platform' => 'android',
            'version' => '13',
            'model' => 'Test Device',
            'app_version' => '1.0.0'
        ]
    ]
);

// Verify
$patient->patientInfo;
```

---

## Getting Access Token for Testing

### 1. Login Patient via API

```bash
curl -X POST http://localhost:8000/api/v1/patient/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "patient@example.com",
    "password": "password"
  }'
```

Response will include `access_token`:

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
    "token_type": "Bearer",
    "expires_in": 31536000
}
```

Use this token in the `Authorization` header:

```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...
```

---

## Verification Queries

### Check if FCM Token is Stored

```sql
SELECT p.id, p.name, pi.fcm_token, pi.current_lang, pi.device_info
FROM patients p
LEFT JOIN patient_info pi ON p.id = pi.patient_id
WHERE p.id = 1;
```

### Check All Patients with FCM Tokens

```sql
SELECT p.id, p.name, p.email, pi.fcm_token, pi.device_info
FROM patients p
INNER JOIN patient_info pi ON p.id = pi.patient_id
WHERE pi.fcm_token IS NOT NULL;
```

### Count Patients Ready for Notifications

```sql
SELECT COUNT(*) as patients_with_fcm_tokens
FROM patient_info
WHERE fcm_token IS NOT NULL;
```
