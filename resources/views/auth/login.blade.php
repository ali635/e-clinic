@extends('layout.defult')
@section('content')

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{__('Sign in to your account')}}
            </h2>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('patient.login') }}">
            @csrf
            
            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ __('Email Address')}}
                </label>
                <input 
                    id="email" 
                    name="email" 
                    type="email"
                    required 
                    class="form-input"
                    placeholder="{{__('Enter your email')}}"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{__('Password')}}
                </label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    class="form-input"
                    placeholder="{{__('Enter your password')}}"
                >
                @error('password')
                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        {{__('Remember me')}}
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-primary hover:text-primary/80">
                        {{__('Forgot your password?')}}
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200"
                >
                    {{__('Sign in')}}
                </button>
            </div>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{__('Don`t have an accout ? ')}}
                <a href="{{route('patient.register')}}" class="font-medium text-primary hover:text-primary/80">
                    {{__('create a new account')}}
                </a>
            </p>
        </form>
    </div>
</div>

@endsection
