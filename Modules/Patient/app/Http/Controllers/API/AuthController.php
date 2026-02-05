<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Location\Models\City;
use Modules\Patient\Http\Requests\PatientRegisterApiRequest;
use Modules\Patient\Models\Patient;
use Modules\Patient\Http\Requests\PatientLoginRequest;
use Modules\Patient\Http\Requests\PatientRegisterRequest;
use Modules\Patient\Models\Referral;

class AuthController extends Controller
{
    /**
     * Register new patient
     */
    public function register(PatientRegisterApiRequest $request)
    {
        // Get validated data FIRST
        $data = $request->validated();

        // Get country_id from city
        $country_id = City::where('id', $request->city_id)->value('country_id');
        $data['country_id'] = $country_id;

        // Handle referral creation if provided (use $data, not undefined $validated)
        $data['referral_id'] = $this->handleReferral($data['refferal'] ?? null);

        // Remove refferal from data as it's not a column in patients table
        unset($data['refferal']);

        // Handle profile image upload
        $data['img_profile'] = $this->handleProfileImage($request);

        $data['status'] = 1;
        $data['password'] = Hash::make($data['password']);

        $patient = Patient::create($data);

        $token = $patient->createToken('PatientAuthToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => __('Registration successful'),
            'data' => [
                'patient' => $patient,
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Login patient
     */
    public function login(PatientLoginRequest $request)
    {
        $credentials = $request->only('phone', 'password');

        $patient = Patient::where('phone', $credentials['phone'])->first();

        if (!$patient || !Hash::check($credentials['password'], $patient->password)) {
            return response()->json([
                'status' => false,
                'message' => __('Invalid phone or password'),
            ], 401);
        }
        if ($patient->status == 0) {
            return response()->json([
                'status' => false,
                'message' => __('User Is Disabled'),
            ], 401);
        }


        $token = $patient->createToken('PatientAuthToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => __('Login successful'),
            'data' => [
                'patient' => $patient,
                'token' => $token,
            ],
        ]);
    }

    private function handleReferral(?string $referralName): ?int
    {
        if (empty($referralName)) {
            return null;
        }

        $referral = Referral::firstOrCreate(['name' => $referralName]);


        return $referral->id;
    }

    /**
     * Handle profile image upload.
     */
    private function handleProfileImage(PatientRegisterApiRequest $request): ?string
    {
        if (!$request->hasFile('img_profile')) {
            return null;
        }

        return $request->file('img_profile')->store('patients/profiles', 'public');
    }

}
