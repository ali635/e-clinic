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
            'schedules' => $service->schedules->map(function ($schedule) use ($daysMap) {
                $dayValue = strtolower($schedule->day_of_week->value); // ✅ get enum value as string
                return [
                    'id' => $schedule->id,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'day_of_week' => $daysMap[$dayValue] ?? null, // convert to numeric day
                    'service_id' => $schedule->service_id,
                ];
            }),
        ],
        'booked_times' => $booked_times ?? [],
    ];

    $book_service_data = [
        'patient_id' => auth('patient')->user()?->id,
        'patient_description' => __('What are you suffering from ?'),
        'book_now' => __('Book Now'),
        'missing_data' => __('Missing Data'),
        'something_wrong' => __('Something went Wrong please try again'),
    ]
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
                            <svg class="w-6 h-6 me-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
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
                <button 
                    @php
                        $dataModalTarget = (isset($book_service_data['patient_id']) && $book_service_data['patient_id']) ? 'book-modal' : 'login-modal';
                    @endphp
                    data-modal-target="{{ $dataModalTarget }}" 
                    data-modal-toggle="{{ $dataModalTarget }}"
                    class="bg-white text-primary font-bold py-4 px-8 rounded-full text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 flex items-center cursor-pointer"
                >
                    <svg class="w-6 h-6 me-2" fill="currentColor" viewBox="0 0 20 20">
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
                <form class="space-y-6" method="POST">
                    <div id="vue-app">
                        <book-service service-data-obj='@json($service_details)' data-obj='@json($book_service_data)'></book-service>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="login-modal" tabindex="-1" aria-hidden="true"
        class="loginModalWrapper hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 tablet:p-6 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm p-4">
                <!-- Icon -->
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-10 w-10 fill-blue-600" fill="none"><path d="M608-522 422-708q14-6 28.5-9t29.5-3q59 0 99.5 40.5T620-580q0 15-3 29.5t-9 28.5ZM234-276q51-39 114-61.5T480-360q18 0 34.5 1.5T549-354l-88-88q-47-6-80.5-39.5T341-562L227-676q-32 41-49.5 90.5T160-480q0 59 19.5 111t54.5 93Zm498-8q32-41 50-90.5T800-480q0-133-93.5-226.5T480-800q-56 0-105.5 18T284-732l448 448ZM480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-60Z"/></svg>
                </div>

                <!-- Title -->
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Login Required</h2>

                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    To book your appointment, please log in to your account.<br />
                    This helps us save your booking details and manage your visits easily.
                </p>
                <div class="flex justify-center gap-2">
                    <a href="{{ route('patient.login') }}" class="bg-primary text-white px-6 py-2 flex items-center rounded-full transition-colors duration-300 capitalize hover:bg-primary/60">
                        {{ __('sign in') }}
                    </a>
                    <a href="{{ route('patient.register') }}" class="bg-primary text-white px-6 py-2 flex items-center rounded-full transition-colors duration-300 capitalize hover:bg-primary/60">
                        {{ __('register') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
