@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        @include('patient.profile.button-menu', compact('stars'))

        <!-- Profile Display Card -->
        <div class="max-w-4xl mx-auto">
            <div id="profileDisplay" class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 sm:p-8 animate-fade-in">
                
                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row items-center sm:items-center justify-between gap-6 pb-6 mb-6 border-b border-gray-200">
                    <div class="flex items-center gap-6">
                        <!-- Profile Image -->
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img onerror="this.src='{{ asset('storage/' . setting('site_logo')) }}'"
                                    src="{{ asset('storage/' . $patient->img_profile) }}" 
                                    alt="{{ $patient->name }}"
                                    class="w-24 h-24 rounded-full object-cover ring-4 ring-primary/10 shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Basic Info -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $patient->name ?? __('Guest User') }}</h2>
                            <p class="text-gray-600 font-medium">{{ $patient->email ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <a href="{{ route('patient.profile.show.form') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-lg hover:from-primary/90 hover:to-primary/80 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-4.036L15.732 3.732z" />
                        </svg>
                        {{ __('Edit Profile') }}
                    </a>
                </div>

                <!-- Profile Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-5">
                        <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">
                            {{ __('Personal Information') }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Gender') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ ucfirst($patient->gender ?? '-') }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Date of Birth') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->date_of_birth ? Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') : '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ __('Marital Status') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ ucfirst($patient->marital_status ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-5">
                        <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">
                            {{ __('Contact Information') }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ __('Primary Phone') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->phone ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ __('Other Phone') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->other_phone ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Address') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm text-right max-w-xs">
                                    {{ $patient->address ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="space-y-5">
                        <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">
                            {{ __('Location') }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ __('City') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->city->name ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ __('Area') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->area->name ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="space-y-5">
                        <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100">
                            {{ __('Additional Information') }}
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    {{ __('Referral') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->referral->name ?? '-' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                                <span class="text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                    {{ __('Hear About Us') }}
                                </span>
                                <span class="text-sm font-medium text-gray-900 px-3 py-1 bg-white rounded-md shadow-sm">
                                    {{ $patient->hear_about_us ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection