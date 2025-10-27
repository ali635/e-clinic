<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Http\Requests\PatientLoginRequest;
use Modules\Patient\Http\Requests\PatientRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Location\Models\City;
use Modules\Patient\Models\Patient;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        $cities = City::where('status', 1)->orderBy('order', 'desc')->get();
        return view('auth.register', compact('cities'));
    }

    public function login(PatientLoginRequest $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

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
        $country_id = City::where('id', $request->city_id)->value('country_id');

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'country_id' => $country_id,
            'city_id' => $request->city_id,
            'other_phone' => $request->other_phone,
            'area_id' => $request->area_id,
            'hear_about_us' => $request->hear_about_us,
            'status' => 1,
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
