@extends('layout.defult')
@section('content')

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="">
            @csrf
            
            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <input 
                    id="email" 
                    name="email" 
                    type="email"
                    required 
                    class="form-input"
                    placeholder="Enter your email"
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
                    Password
                </label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    class="form-input"
                    placeholder="Enter your password"
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
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-primary hover:text-primary/80">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200"
                >
                    Sign in
                </button>
            </div>
            <p class="mt-2 text-center text-sm text-gray-600">
                Don't have an accout ? 
                <a href="/register" class="font-medium text-primary hover:text-primary/80">
                    create a new account
                </a>
            </p>
        </form>
    </div>
</div>

<!-- <div class="space-y-2">
    <label for="message" class="block text-sm font-medium text-gray-700">
        Message
    </label>
    <textarea 
        id="message" 
        name="message" 
        rows="4"
        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm bg-transparent transition-colors duration-200 resize-none"
        placeholder="Enter your message"
    >{{ old('message') }}</textarea>
    @error('message')
        <div class="text-red-600 text-sm mt-1">
            {{ $message }}
        </div>
    @enderror
</div> -->
@endsection
