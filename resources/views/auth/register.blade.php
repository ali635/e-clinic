@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', __('Create Account | Dr Azad Hasan Clinic System'))
@section('description', __('Register a new account on the Dr Azad Hasan Clinic System to book appointments and access
    health services.'))
@section('keywords', __('register, sign up, create account, Dr Azad Hasan, clinic system, medical registration'))
@section('og_title', __('Create Account | Dr Azad Hasan Clinic System'))
@section('og_description', __('Register a new account on the Dr Azad Hasan Clinic System to book appointments and access
    health services.'))
@section('og_type', 'website')
@section('twitter_title', __('Create Account | Dr Azad Hasan Clinic System'))
@section('twitter_description', __('Register a new account on the Dr Azad Hasan Clinic System to book appointments and
    access health services.'))

@section('content')
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-white/50"></div>

        <div class="max-w-4xl w-full relative z-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 mb-4">
                    {{-- <div class="w-full h-full bg-gradient-to-br from-primary to-primary/80 rounded-2xl shadow-lg flex items-center justify-center text-white text-2xl font-bold">
                        3M
                    </div> --}}
                </div>
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ __('Create Your Account') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('Join our clinic to access medical services and book appointments') }}
                </p>
            </div>

            <!-- Error Summary -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-red-700 font-medium">
                            {{ __('Please correct the errors below') }}
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6 genericForm bg-white p-8 rounded-2xl shadow-xl border border-gray-200" method="POST"
                action="{{ route('patient.register.post') }}" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Full Name Field -->
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('First Name') }}
                        </label>
                        <input id="first_name" name="first_name" type="text" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your First name') }}" value="{{ old('first_name') }}">
                        @error('first_name')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Last Name Field -->
                    <div class="space-y-2">
                        <label for="middle_name" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Middle Name') }}
                        </label>
                        <input id="middle_name" name="middle_name" type="text" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your Middle name') }}" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Last Name Field -->
                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Last Name') }}
                        </label>
                        <input id="last_name" name="last_name" type="text" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your Last name') }}" value="{{ old('last_name') }}">
                        @error('last_name')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ __('Email Address') }}
                        </label>
                        <input id="email" name="email" type="email" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your email') }}" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Phone Number Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ __('Phone Number') }}
                        </label>
                        <input id="phone" name="phone" type="number"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your phone number') }}" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Another Phone Number Field -->
                    <div class="space-y-2">
                        <label for="other_phone" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ __('Another Phone Number') }}
                        </label>
                        <input id="other_phone" name="other_phone" type="number"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter another phone number') }}" value="{{ old('other_phone') }}">
                        @error('other_phone')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Date Field -->
                    <div class="space-y-2">
                        <label for="date" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('date of birth') }}
                        </label>
                        <input id="date" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                        @error('date_of_birth')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Gender Select Field -->
                    <div class="space-y-2">
                        <label for="gender" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('gender') }}
                        </label>
                        <select id="gender" name="gender"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            <option value="">{{ __('Select your gender') }}</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                {{ __('Male') }}
                            </option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                {{ __('Female') }}
                            </option>
                        </select>
                        @error('gender')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Marital Status Select Field -->
                    <div class="space-y-2 lg:col-span-2">
                        <label for="marital_status"
                            class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            {{ __('Marital Status') }}
                        </label>
                        <select id="marital_status" name="marital_status"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            <option value="">{{ __('Select marital status') }}</option>
                            <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>
                                {{ __('Single') }}
                            </option>
                            <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                {{ __('Married') }}
                            </option>
                            <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>
                                {{ __('Divorced') }}
                            </option>
                            <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>
                                {{ __('Widowed') }}
                            </option>
                        </select>
                        @error('marital_status')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- City Select Field -->
                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('city') }}
                        </label>
                        <select id="city" name="city_id"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            <option value="">{{ __('Select your city') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @php
                        $city_id = old('city_id');
                        $areas = Modules\Location\Models\Area::where('city_id', $city_id)->get();
                    @endphp
                    <!-- Area Select Field -->
                    <div class="space-y-2">
                        <label for="area" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Area') }}
                        </label>
                        <select id="area" name="area_id"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            <option value="">{{ __('Select your area') }}</option>
                            @if (isset($areas))
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            @endif

                        </select>
                        @error('area_id')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div class="space-y-2 lg:col-span-2">
                        <label for="street" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5A2.5 2.5 0 0013.5 5.5V3.935M7 3h10a2 2 0 012 2v2m-6 10h4a2 2 0 002-2v-2M7 17h4m-4 0a2 2 0 11-4 0m0 0V6a2 2 0 012-2h4a2 2 0 012 2v11m0 0a2 2 0 11-4 0" />
                            </svg>
                            {{ __('address') }}
                        </label>
                        <input id="street" name="address" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your address') }}" value="{{ old('address') }}">
                        @error('address')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            {{ __('password') }}
                        </label>
                        <input id="password" name="password" type="password" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter your password') }}">
                        @error('password')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-2">
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            {{ __('Confirm Password') }}
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Confirm your password') }}">
                        @error('password_confirmation')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Where did you hear about us Field -->
                    <div class="space-y-2">
                        <label for="hear_about_us"
                            class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ __('Where did you hear about us?') }}
                        </label>
                        <input id="hear_about_us" name="hear_about_us" required
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter where you heard about us') }}" value="{{ old('hear_about_us') }}">
                        @error('hear_about_us')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Referral Field -->
                    <div class="space-y-2">
                        <label for="refferal" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            {{ __('Referral (Optional)') }}
                        </label>
                        <input id="refferal" name="refferal"
                            class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                            placeholder="{{ __('Enter referral code if any') }}" value="{{ old('refferal') }}">
                        @error('refferal')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Image Profile Field -->
                    <div class="space-y-2 lg:col-span-2">
                        <label for="img_profile"
                            class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L12.929 16H16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('Profile Image') }}
                        </label>
                        <input id="img_profile" type="file" name="img_profile"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer transition-colors duration-200">
                        @error('img_profile')
                            <div class="text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-primary to-primary/80 text-white font-semibold rounded-lg hover:from-primary/90 hover:to-primary/70 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        {{ __('Create Account') }}
                    </button>
                </div>

            </form>

            <!-- Login Link -->
            <p
                class="mt-6 text-center text-sm text-gray-600 bg-white py-3 px-6 rounded-xl shadow-md border border-gray-200 max-w-md mx-auto">
                {{ __('Already have an account?') }}
                <a href="{{ route('patient.login') }}"
                    class="font-semibold text-primary hover:text-primary/80 transition-colors duration-200">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </div>

    <!-- Keep original script -->
    <script>
        const city = document.querySelector("#city");
        let currentLocale = "{{ app()->getLocale() }}";
        city.addEventListener("change", function() {
            const cityId = this.value;
            const area = document.querySelector("#area");
            let optionsStr = `<option value="">{{ __('Select your area') }}</option>`;
            area.innerHTML = optionsStr;
            if (cityId) {
                fetch(`/api/v1/countries/${cityId}/areas?lang=${currentLocale}`)
                    .then(response => response.json())
                    .then(data => {
                        const areas = data?.data || [];
                        areas.forEach(area => {
                            optionsStr += `<option value="${area.id}">${area.name}</option>`;
                        });
                        area.innerHTML = optionsStr;
                    });
            }
        });
    </script>
@endsection
