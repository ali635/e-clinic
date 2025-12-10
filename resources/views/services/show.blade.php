@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', __(':serviceName - 3M Medical System', ['serviceName' => $service->name]))
@section('description',
    __(':serviceName details, price, and booking information at 3M Medical System. :shortDesc', [
    'serviceName' => $service->name,
    'shortDesc' => strip_tags(Str::limit($service->short_description, 150)),
    ]))
@section('keywords', __(':serviceName, clinic services, booking, healthcare, doctors, medical system, 3M services',
    ['serviceName' => $service->name]))

@section('og_title', __(':serviceName - 3M Medical System', ['serviceName' => $service->name]))
@section('og_description',
    __(':serviceName details, price, and booking information at 3M Medical System. :shortDesc', [
    'serviceName' => $service->name,
    'shortDesc' => strip_tags(Str::limit($service->short_description, 150)),
    ]))
@section('og_type', 'article')

@section('twitter_title', __(':serviceName - 3M Medical System', ['serviceName' => $service->name]))
@section('twitter_description',
    __(':serviceName details, price, and booking information at 3M Medical System. :shortDesc', [
    'serviceName' => $service->name,
    'shortDesc' => strip_tags(Str::limit($service->short_description, 150)),
    ]))

@section('content')
    @php
        $isProductionMode = config(key: 'app.env') == 'production';

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
                    $dayValue = strtolower($schedule->day_of_week->value);
                    return [
                        'id' => $schedule->id,
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'day_of_week' => $daysMap[$dayValue] ?? null,
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
        ];
    @endphp

    @if ($isProductionMode)
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/js/app.js']['css'][0] ?? '') }}">
    @endif

    <!-- Hero Section -->
    <section class="relative h-[60vh] min-h-[400px] overflow-hidden">
        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

        <div class="absolute inset-0 flex items-end">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-8">
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight capitalize drop-shadow-lg">
                    {{ $service->name }}
                </h1>
                <div class="flex items-center gap-4 text-white/90">
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $service->patient_time_minute ?? '45' }} {{ __('minutes') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Details -->
    <section class="py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                            {{ __('Service Details') }}
                        </h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! $service->description !!}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div
                        class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 border border-primary/20 shadow-md">
                        <h3
                            class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-primary/20">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                    <svg class="w-4 h-4 me-1" fill="currentColor" viewBox="0 0 20 20">
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

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-primary/90 text-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('Ready to Book This Service?') }}
            </h2>
            <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                {{ __('Get started today and experience our professional service with guaranteed quality and care.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @php
                    $dataModalTarget =
                        isset($book_service_data['patient_id']) && $book_service_data['patient_id']
                            ? 'book-modal'
                            : 'login-modal';
                @endphp
                <button data-modal-target="{{ $dataModalTarget }}" data-modal-toggle="{{ $dataModalTarget }}"
                    class="bg-white text-primary font-bold py-4 px-8 rounded-full text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-lg cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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

    <!-- Book Modal -->
    <div id="book-modal" tabindex="-1" aria-hidden="true"
        class="bookModalWrapper hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-primary flex items-center gap-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('Book Service') }}
                    </h3>
                    <button data-modal-hide="book-modal"
                        class="w-9 h-9 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="space-y-6" method="POST">
                    <div id="vue-app">
                        <book-service service-data-obj='@json($service_details)'
                            data-obj='@json($book_service_data)'></book-service>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="login-modal" tabindex="-1" aria-hidden="true"
        class="loginModalWrapper hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl p-8">
                <!-- Icon -->
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-3">{{ __('Login Required') }}</h2>

                <!-- Message -->
                <p class="text-gray-600 text-center mb-8 leading-relaxed">
                    {{ __('To book your appointment, please log in to your account.') }}
                    <br />
                    {{ __('This helps us save your booking details and manage your visits easily.') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('patient.login') }}"
                        class="bg-primary text-white px-6 py-3 flex items-center justify-center gap-2 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        {{ __('Sign In') }}
                    </a>
                    <a href="{{ route('patient.register') }}"
                        class="border-2 border-primary text-primary px-6 py-3 flex items-center justify-center gap-2 rounded-full font-semibold hover:bg-primary hover:text-white transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                        {{ __('Register') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
