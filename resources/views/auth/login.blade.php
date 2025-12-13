@extends('layout.defult')

@section('title', __('Login | Dr Azad Hasan Clinic System'))
@section('description', __('Sign in to your Dr Azad Hasan Clinic System account to access your medical services and appointments.'))
@section('keywords', __('login, patient login, Dr Azad Hasan Clinic account, medical system'))
@section('og_title', __('Login | Dr Azad Hasan System'))
@section('og_description', __('Sign in to your Dr Azad Hasan Clinic System account to access your medical services and appointments.'))
@section('og_type', 'website')
@section('twitter_title', __('Login | Dr Azad Hasan System'))
@section('twitter_description', __('Sign in to your Dr Azad Hasan Clinic System account to access your medical services and appointments.'))

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-white/50"></div>
        
        <div class="max-w-md w-full space-y-8 relative z-10">
            <!-- Logo/Header -->
            <div class="text-center">
                <div class="mx-auto w-16 h-16">
                    
                </div>
                <h2 class="mt-8 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('Welcome Back') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('Sign in to access your medical services and appointments') }}
                </p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6 genericForm bg-white p-8 rounded-2xl shadow-xl border border-gray-200" method="POST" action="{{ route('patient.login') }}">
                @csrf

                <!-- Phone Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ __('Phone Number') }}
                    </label>
                    <input id="phone" name="phone" type="number" required 
                           class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                           placeholder="{{ __('Enter your phone number') }}" 
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('password') }}
                    </label>
                    <input id="password" name="password" type="password" required 
                           class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                           placeholder="{{ __('Enter your password') }}">
                    @error('password')
                        <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember_me" type="checkbox"
                               class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-700 font-medium">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    {{-- <div class="text-sm">
                        <a href="{{ route('patient.password.request') }}" class="font-medium text-primary hover:text-primary/80 transition-colors duration-200">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div> --}}
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-primary to-primary/80 text-white font-semibold rounded-lg hover:from-primary/90 hover:to-primary/70 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('Sign in') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">{{ __('New to our clinic?') }}</span>
                    </div>
                </div>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('patient.register') }}" class="font-semibold text-primary hover:text-primary/80 transition-colors duration-200">
                        {{ __('Create a new account') }}
                    </a>
                </p>
            </form>

            <!-- Additional Info -->
            {{-- <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    {{ __('By signing in, you agree to our') }}
                    <a href="{{ route('terms') }}" class="text-primary hover:underline">{{ __('Terms') }}</a>
                    {{ __('and') }}
                    <a href="{{ route('privacy') }}" class="text-primary hover:underline">{{ __('Privacy Policy') }}</a>
                </p>
            </div> --}}
        </div>
    </div>
@endsection