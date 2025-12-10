@extends('patient.share.sidbar')
@section('patient_content')
<!-- Main Content -->
<main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            {{ __('Statistics') }}
        </h2>
        <p class="text-gray-600 mt-2">{{ __('Your health journey at a glance') }}</p>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- Completed Visits Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-full p-4 shadow-md">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-3xl font-bold text-gray-900">{{ number_format($completedVisits) }}</div>
                <div class="text-gray-500 font-medium">{{ __('Completed Visits') }}</div>
                <div class="mt-1 text-sm text-green-600 font-semibold">{{ __('All finished appointments') }}</div>
            </div>
        </div>

        <!-- Pending Visits Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-br from-amber-100 to-amber-200 rounded-full p-4 shadow-md">
                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-3xl font-bold text-gray-900">{{ number_format($notCompletedVisits) }}</div>
                <div class="text-gray-500 font-medium">{{ __('Pending Visits') }}</div>
                <div class="mt-1 text-sm text-amber-600 font-semibold">{{ __('In progress or scheduled') }}</div>
            </div>
        </div>

        <!-- Success Rate Card -->
        @if ($completedVisits + $notCompletedVisits > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-br from-primary/10 to-primary/20 rounded-full p-4 shadow-md">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-3xl font-bold text-gray-900">{{ round(($completedVisits / ($completedVisits + $notCompletedVisits)) * 100) }}%</div>
                    <div class="text-gray-500 font-medium">{{ __('Completion Rate') }}</div>
                    <div class="mt-1 text-sm text-primary font-semibold">{{ __('Visit completion ratio') }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Insights -->
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            {{ __('Quick Insights') }}
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">{{ __('Last Visit') }}</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $date_of_last_visit ?: __('No visits yet') }}</p>
                </div>
            </div>

            @if ($completedVisits > 0)
                <div class="flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600">{{ __('Total Visits') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($completedVisits + $notCompletedVisits) }} {{ __('visits') }}</p>
                    </div>
                </div>
            @endif

            <div class="flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">{{ __('Account Status') }}</p>
                    <p class="text-lg font-semibold text-green-600">{{ __('Active') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">{{ __('Health Score') }}</p>
                    <p class="text-lg font-semibold text-purple-600">{{ min(100, $completedVisits * 10) }}/100</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection