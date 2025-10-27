@extends('layout.defult')
@section('content')
    @php
        $daysMap = [
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            'sunday' => 7,
        ];
        $service_details = [
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'short_description' => $service->short_description ?? '',
                'description' => $service->description ?? '',
                'price' => $service->price ?? '',
                'patient_time_minute' => $service->patient_time_minute ?? '',
                'image' => $service->image ? asset('storage/' . $service->image) : asset('images/default-service.jpg'),
                'is_home' => $service->is_home ?? false,
                'schedules' => $service->schedules->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'day_of_week' => \Carbon\Carbon::parse($schedule->day_of_week)->dayOfWeekIso,
                        'service_id' => $schedule->service_id,
                    ];
                }),
            ],
            'booked_times' => $bookedTimes ?? [],
        ];
        
    @endphp
    <!-- Hero Section with Service Image -->
    <section class="service-hero relative h-[60vh] min-h-[400px] overflow-hidden">
        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/20"></div>

        <!-- Hero Content -->
        <div class="absolute inset-0 top-1/2 -translate-y-1/2 flex items-end z-10">
            <div class="container pb-12">
                <h1 class="text-4xl tablet:text-5xl web:text-6xl font-bold text-white mb-4 leading-tight capitalize">
                    {{ $service->name }}
                </h1>
            </div>
        </div>
    </section>

    <!-- Service Details Section -->
    <section class="py-16 bg-white animate-slide-up">
        <div class="container">
            <div class="grid grid-cols-1 web:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="web:col-span-2 order-2 web:order-1">
                    <div class="prose prose-lg max-w-none">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Service Details') }}</h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $service->description !!}
                        </div>
                    </div>
                </div>

                <!-- Service Information Sidebar -->
                <div class="space-y-6 order-1 web:order-2">
                    <!-- Service Info Card -->
                    <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 border border-primary/20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Service Information') }}
                        </h3>

                        <div class="space-y-4">
                            @if ($service->price)
                                <div class="flex items-center justify-between py-3 border-b border-primary/20">
                                    <span class="text-gray-600 font-medium">{{ __('Price') }}</span>
                                    <span class="text-xl font-bold text-primary">{{ $service->price }}
                                        {{ __('IQD') }}</span>
                                </div>
                            @endif

                            @if ($service->start && $service->end)
                                <div class="flex items-center justify-between py-3 border-b border-primary/20">
                                    <span class="text-gray-600 font-medium">{{ __('Available Hours') }}</span>
                                    <span
                                        class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($service->start)->format('h:i A') }}
                                        - {{ \Carbon\Carbon::parse($service->end)->format('h:i A') }}</span>
                                </div>
                            @endif

                            @if ($service->patient_time_minute)
                                <div class="flex items-center justify-between py-3 border-b border-primary/20">
                                    <span class="text-gray-600 font-medium">{{ __('Duration') }}</span>
                                    <span class="text-gray-900 font-semibold">{{ $service->patient_time_minute }}
                                        {{ __('minutes') }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between py-3">
                                <span class="text-gray-600 font-medium">{{ __('Status') }}</span>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('Available') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-primary/80">
        <div class="container text-center">
            <h2 class="text-3xl tablet:text-4xl font-bold text-white mb-4">
                {{ __('Ready to Book This Service?') }}
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                {{ __('Get started today and experience our professional service with guaranteed quality and care.') }}
            </p>
            <div class="flex flex-col tablet:flex-row gap-4 justify-center items-center">
                <button data-modal-target="book-modal" data-modal-toggle="book-modal"
                    class="bg-white text-primary font-bold py-4 px-8 rounded-full text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 flex items-center cursor-pointer">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ __('Book Now') }}
                </button>
                <a href="{{ route('services') }}"
                    class="border-2 border-white text-white font-semibold py-4 px-8 rounded-full text-lg hover:bg-white hover:text-primary transition-all duration-300">
                    {{ __('View All Services') }}
                </a>
            </div>
        </div>
    </section>

    <div id="book-modal" tabindex="-1" aria-hidden="true"
        class="bookModalWrapper hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm p-4">
                <!-- Modal body -->
                <form class="space-y-6" method="POST" action="">
                    <div class="flex justify-end !mb-0">
                        <button type="button"
                            class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="book-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">{{ __('Close modal') }}</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <!-- Services Field -->
                        <div class="space-y-2">
                            <label for="services" class="block text-sm font-medium text-gray-700">
                                {{ __('services') }}
                            </label>
                            <input id="services" name="services" type="hidden" class="form-input"
                                value="{{ $service->id }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div id="vue-app">
                        <book-service data-obj='@json($service_details)'></book-service>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 cursor-pointer max-w-sm mx-auto">
                            {{ __('Book Now') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
