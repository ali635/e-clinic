<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Location\Models\City;
use Modules\Patient\Http\Requests\PatientLoginRequest;
use Modules\Patient\Http\Requests\PatientRegisterRequest;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Referral;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Show registration form.
     */
    public function create(): View
    {
        $cities = City::where('status', 1)->orderBy('order', 'desc')->get();
        
        return view('auth.register', compact('cities'));
    }

    /**
     * Handle patient login.
     */
    public function login(PatientLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('phone', 'password');
        $rememberMe = $request->boolean('remember_me');

        if (Auth::guard('patient')->attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();

            return redirect()->intended(route('patient.dashboard'))
                ->with('success', __('Welcome back!'));
        }

        return back()
            ->withErrors(['phone' => __('The provided credentials do not match our records.')])
            ->onlyInput('phone');
    }

    /**
     * Handle patient registration.
     */
    public function register(PatientRegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Get country_id from selected city
        $countryId = City::where('id', $validated['city_id'])->value('country_id');

        // Handle referral creation if provided
        $referralId = $this->handleReferral($validated['refferal'] ?? null);
        // Handle profile image upload
        $imgProfilePath = $this->handleProfileImage($request);
        
        // Create patient with mass assignment
        $patient = Patient::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'other_phone' => $validated['other_phone'] ?? null,
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'country_id' => $countryId,
            'city_id' => $validated['city_id'],
            'area_id' => $validated['area_id'] ?? null,
            'hear_about_us' => $validated['hear_about_us'],
            'status' => 1,
            'password' => Hash::make($validated['password']),
            'referral_id' => $referralId,
            'img_profile' => $imgProfilePath,
        ]);

        Auth::guard('patient')->login($patient);

        ToastMagic::success(__('Account created successfully.'));

        return redirect()->route('patient.dashboard')
            ->with('success', __('Account created successfully.'));
    }

    /**
     * Handle patient logout.
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('patient')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('patient.login')
            ->with('success', __('You have been logged out.'));
    }

    /**
     * Handle referral creation.
     */
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
    private function handleProfileImage(PatientRegisterRequest $request): ?string
    {
        if (!$request->hasFile('img_profile')) {
            return null;
        }

        return $request->file('img_profile')->store('patients/profiles', 'local');
    }
}
