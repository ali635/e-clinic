<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <!-- Profile Header with Stars -->
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
            {{ __('Profile') }}
            <span class="inline-flex items-center gap-1 bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-1 rounded-full">
                <span class="text-yellow-500 text-lg font-semibold">{{ $stars }}</span>
                @for ($i = 0; $i < $stars; $i++)
                    <span class="text-yellow-400 text-xl animate-pulse">★</span>
                @endfor
                <span class="text-gray-600 text-sm font-medium ml-1">{{ __('Stars Member') }}</span>
            </span>
        </h1>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('patient.profile.data') }}"
            class="inline-flex items-center px-4 py-2 border border-primary rounded-lg text-sm font-medium transition-all duration-200 
            @if (Route::is('patient.profile.data')) 
                bg-gradient-to-r from-primary to-primary/90 text-white shadow-md 
            @else 
                bg-white text-primary hover:bg-gradient-to-r hover:from-primary hover:to-primary/90 hover:text-white hover:shadow-md
            @endif">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('Profile Information') }}
        </a>

        <a href="{{ route('patient.profile.show.form') }}"
            class="inline-flex items-center px-4 py-2 border border-primary rounded-lg text-sm font-medium transition-all duration-200 
            @if (Route::is('patient.profile.show.form')) 
                bg-gradient-to-r from-primary to-primary/90 text-white shadow-md 
            @else 
                bg-white text-primary hover:bg-gradient-to-r hover:from-primary hover:to-primary/90 hover:text-white hover:shadow-md
            @endif">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-4.036L15.732 3.732z" />
            </svg>
            {{ __('Edit Profile') }}
        </a>

        <a href="{{ route('patient.profile.show.form.password') }}"
            class="inline-flex items-center px-4 py-2 border border-primary rounded-lg text-sm font-medium transition-all duration-200 
            @if (Route::is('patient.profile.show.form.password')) 
                bg-gradient-to-r from-primary to-primary/90 text-white shadow-md 
            @else 
                bg-white text-primary hover:bg-gradient-to-r hover:from-primary hover:to-primary/90 hover:text-white hover:shadow-md
            @endif">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            {{ __('Edit Password') }}
        </a>
    </div>
</div>