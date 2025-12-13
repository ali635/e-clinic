@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        @include('patient.profile.button-menu', compact('stars'))

        <!-- Password Change Form -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 sm:p-8 animate-fade-in">
                
                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        {{ __('Change Password') }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        {{ __('Update your password to keep your account secure') }}
                    </p>
                </div>

                <form id="profileEditForm" method="POST" action="{{ route('patient.profile.update.password') }}">
                    @csrf
                    
                    <!-- Password Fields -->
                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="old_password" class="block text-sm font-semibold text-gray-800 mb-2">
                                {{ __('Current Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="old_password" name="old_password" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                                    placeholder="{{ __('Enter your current password') }}" required>
                                <button type="button" class="absolute inset-y-0 end-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    onclick="togglePassword('old_password')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('old_password')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                                {{ __('New Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                                    placeholder="{{ __('Enter your new password') }}" required>
                                <button type="button" class="absolute inset-y-0 end-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    onclick="togglePassword('password')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-2">
                                {{ __('Confirm New Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                                    placeholder="{{ __('Confirm your new password') }}" required>
                                <button type="button" class="absolute inset-y-0 end-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    onclick="togglePassword('password_confirmation')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200 mt-8">
                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-primary to-primary/80 text-white font-semibold rounded-lg hover:from-primary/90 hover:to-primary/70 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Update Password') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.type === 'password' ? 'text' : 'password';
            field.type = type;
        }
    </script>
@endsection