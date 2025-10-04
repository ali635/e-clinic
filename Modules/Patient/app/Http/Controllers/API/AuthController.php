<?php

namespace Modules\Patient\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Patient\Models\Patient;
use Modules\Patient\Http\Requests\PatientLoginRequest;
use Modules\Patient\Http\Requests\PatientRegisterRequest;

class AuthController extends Controller
{
    /**
     * Register new patient
     */
    public function register(PatientRegisterRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 0; 
        $data['password'] = Hash::make($data['password']);

        $patient = Patient::create($data);

        $token = $patient->createToken('PatientAuthToken')->accessToken;

        return response()->json([
            'status'  => true,
            'message' => 'Registration successful',
            'data'    => [
                'patient' => $patient,
                'token'   => $token,
            ],
        ], 201);
    }

    /**
     * Login patient
     */
    public function login(PatientLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $patient = Patient::where('email', $credentials['email'])->first();

        if (!$patient || !Hash::check($credentials['password'], $patient->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $patient->createToken('PatientAuthToken')->accessToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'data'    => [
                'patient' => $patient,
                'token'   => $token,
            ],
        ]);
    }
}
