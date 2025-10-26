@extends('layout.defult')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/intelTelInput.css') }}">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('Create your account') }}
                </h2>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('patient.register.post') }}">
                @csrf
                <div class="grid grid-cols-1 tablet:grid-cols-2 gap-3">
                    <!-- Full Name Field -->
                    <div class="space-y-2">
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            {{ __('Full Name') }}
                        </label>
                        <input id="full_name" name="name" type="text" required class="form-input"
                            placeholder="{{ __('Enter your full name') }}" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email Address') }}
                        </label>
                        <input id="email" name="email" type="email" required class="form-input"
                            placeholder="Enter your email" value="{{ old('email') }}">
    
                        @error('email')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Phone Number Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            {{ __('Phone Number') }}
                        </label>
                        <input id="phone" name="phone" type="tel" class="form-input"
                            placeholder="Enter your phone number" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Another Phone Number Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            {{ __('Another Phone Number') }}
                        </label>
                        <input id="another_phone" name="another_phone" type="tel" class="form-input"
                            placeholder="Enter your another phone number" value="{{ old('another_phone') }}">
                        @error('another_phone')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Date Field -->
                    <div class="space-y-2">
                        <label for="date" class="block text-sm font-medium text-gray-700">
                            {{ __('Date of Birth') }}
                        </label>
                        <input id="date" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"
                            class="form-input">
                        @error('date_of_birth')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- gender Select Field -->
                    <div class="space-y-2">
                        <label for="gender" class="block text-sm font-medium text-gray-700">
                            {{ __('gender') }}
                        </label>
                        <select id="gender" name="gender" class="form-input">
                            <option value="">{{__('Select your gender')}}</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}
                            </option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}
                            </option>
                        </select>
                        @error('gender')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
    
                    <!-- City Select Field -->
                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            {{ __('City') }}
                        </label>
                        <select id="city" name="city_id" class="form-input">
                            <option value="">{{__('Select your city')}}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Area Select Field -->
                    <div class="space-y-2">
                        <label for="area" class="block text-sm font-medium text-gray-700">
                            {{ __('Area') }}
                        </label>
                        <select id="area" name="area_id" class="form-input">
                            <option value="">{{__('Select your area')}}</option>
                        </select>
                        @error('area_id')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Street Field -->
                    <div class="space-y-2">
                        <label for="street" class="block text-sm font-medium text-gray-700">
                            {{ __('address') }}
                        </label>
                        <input id="street" name="address" required class="form-input"
                            placeholder="{{ __('Enter your address') }}" value="{{ old('address') }}">
                        @error('address')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Where did you hear about us Field -->
                    <div class="space-y-2">
                        <label for="street" class="block text-sm font-medium text-gray-700">
                            {{ __('Where did you hear about us ?') }}
                        </label>
                        <input id="street" name="hear_about_us" required class="form-input"
                            placeholder="{{ __('Enter Where did you hear about us ?') }}" value="{{ old('hear_about_us') }}">
                        @error('hear_about_us')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('Password') }}
                        </label>
                        <input id="password" name="password" type="password" required class="form-input"
                            placeholder="{{ __('Enter your password') }}">
                        @error('password')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <!-- Confirm Password Field -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            {{ __('Confirm Password') }}
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="form-input" placeholder="Confirm your password">
                        @error('password_confirmation')
                            <div class="text-red-600 text-sm mt-1 ">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 cursor-pointer max-w-md mx-auto">
                        {{ __('Create Account') }}
                    </button>
                </div>

            </form>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Already have an account?') }}
                <a href="{{ route('patient.login') }}" class="font-medium text-primary hover:text-primary/80">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </div>
    <script src="{{ asset('js/intelTelInput.js') }}"></script>
    <script>
        const input = document.querySelector("#phone");
        window.intlTelInput(input, {
            loadUtils: () => import("{{ asset('js/intelUtilities.js') }}"),
        });

        const input2 = document.querySelector("#another_phone");
        window.intlTelInput(input2, {
            loadUtils: () => import("{{ asset('js/intelUtilities.js') }}"),
        });


        const city = document.querySelector("#city");
        city.addEventListener("change", function() {
            const cityId = this.value;
            const area = document.querySelector("#area");
            let optionsStr = `<option value="">{{ __('Select your area') }}</option>`;
            area.innerHTML = optionsStr;
            if(cityId){
                fetch(`/api/v1/countries/${cityId}/areas`)
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
