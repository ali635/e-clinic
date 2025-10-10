<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Http\Requests\PatientLoginRequest;
use Modules\Patient\Http\Requests\PatientRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Patient\Models\Patient;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function login(PatientLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('patient')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('patient.dashboard'))
                ->with('success', __('Welcome back!'));
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
        ])->onlyInput('email');
    }

    // Handle register
    public function register(PatientRegisterRequest $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.dashboard')
            ->with('success', __('Account created successfully.'));
    }

    // Handle logout
    public function logout()
    {
        Auth::guard('patient')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('patient.login')
            ->with('success', __('You have been logged out.'));
    }
}
