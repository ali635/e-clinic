<?php

namespace Modules\Firebase\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Firebase\Models\PatientInfo;

class PatientDeviceController extends Controller
{
    /**
     * Update or create patient FCM token and device information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFcmToken(Request $request)
    {
        // Get authenticated patient
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => __('Unauthorized. Please login first.'),
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
            'current_lang' => 'nullable|string|max:10',
            'device_info' => 'nullable|array',
            'device_info.platform' => 'nullable|string',
            'device_info.version' => 'nullable|string',
            'device_info.model' => 'nullable|string',
            'device_info.app_version' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('Validation failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Update or create patient info
            $patientInfo = PatientInfo::updateOrCreate(
                ['patient_id' => $patient->id],
                [
                    'fcm_token' => $request->fcm_token,
                    'current_lang' => $request->current_lang ?? 'en',
                    'device_info' => $request->device_info,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => __('FCM token and device information updated successfully'),
                'data' => [
                    'patient_id' => $patientInfo->patient_id,
                    'fcm_token' => $patientInfo->fcm_token,
                    'current_lang' => $patientInfo->current_lang,
                    'device_info' => $patientInfo->device_info,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update FCM token'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get current patient FCM token and device information.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFcmToken()
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => __('Unauthorized. Please login first.'),
            ], 401);
        }

        $patientInfo = $patient->patientInfo;

        if (!$patientInfo) {
            return response()->json([
                'success' => true,
                'message' => __('No device information found'),
                'data' => null,
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => __('Device information retrieved successfully'),
            'data' => [
                'patient_id' => $patientInfo->patient_id,
                'fcm_token' => $patientInfo->fcm_token,
                'current_lang' => $patientInfo->current_lang,
                'device_info' => $patientInfo->device_info,
            ],
        ], 200);
    }

    /**
     * Delete patient FCM token (for logout).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFcmToken()
    {
        $patient = auth('api')->user();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => __('Unauthorized. Please login first.'),
            ], 401);
        }

        try {
            $patientInfo = $patient->patientInfo;

            if ($patientInfo) {
                // Clear FCM token but keep device info
                $patientInfo->update(['fcm_token' => null]);

                return response()->json([
                    'success' => true,
                    'message' => __('FCM token removed successfully'),
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => __('No FCM token found'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to remove FCM token'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
