@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('Medical History') }}
            </h2>
            <p class="text-gray-600 mt-2">{{ __('Your complete treatment timeline') }}</p>
        </div>

        <!-- Timeline -->
        @if ($histories && $histories->count() > 0)
            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary to-primary/30"></div>
                    
                    <div class="space-y-6">
                        @foreach ($histories as $history)
                            @if ($history->doctor_description)
                                <div class="relative flex gap-4 group">
                                    <!-- Timeline Dot -->
                                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center">
                                        <div class="w-10 h-10 bg-white rounded-full border-4 border-primary shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Content Card -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-200">
                                        <!-- Date Badge -->
                                        <div class="flex items-center gap-2 mb-3">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <time class="text-sm font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}
                                            </time>
                                        </div>

                                        <!-- Doctor Info -->
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ __('Doctor Description') }}
                                        </h3>

                                        <!-- Description Content -->
                                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                            {!! $history->doctor_description !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('No History Yet') }}</h3>
                    <p class="text-gray-500">{{ __('Your medical history will appear here after your visits') }}</p>
                </div>
            </div>
        @endif
    </main>
@endsection