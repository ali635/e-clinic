@extends('patient.share.sidbar')
@section('patient_content')
    <link rel="stylesheet" crossorigin href="{{ asset('css/lightbox.css') }}">

    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <!-- Visit Details Header -->
        <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('Visit Details') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Patient Name') }}:</p>
                            <p class="text-gray-900 font-medium">{{ $patient->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Service') }}:</p>
                            <p class="text-gray-900 font-medium">{{ $visit->service->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Arrival Status') }}:</p>
                            @if ($visit->is_arrival)
                                <p class="text-green-600 font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Yes') }}
                                    <span class="text-gray-600 text-sm font-normal">({{ __('Arrival Time') }}:
                                        {{ $visit->arrival_time }})</span>
                                </p>
                            @else
                                <p class="text-red-500 font-semibold">{{ __('No') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Date/Time') }}:</p>
                            <p class="text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($visit->arrival_time)->format('Y-m-d h:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Total Price') }}:</p>
                            <div class="flex items-center gap-2">
                                @if ($visit->total_after_discount || $visit->total_after_discount == 0)
                                    <span
                                        class="line-through text-gray-500">${{ number_format($visit->total_price, 0) }}</span>
                                    <span
                                        class="text-green-600 font-bold">${{ number_format($visit->total_after_discount, 0) }}</span>
                                @else
                                    <span
                                        class="text-gray-900 font-medium">${{ number_format($visit->total_price, 0) }}</span>
                                @endif
                                <span class="text-primary font-bold">{{ __('IQD') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lab Test Images Section -->
        @if ($visit->lab_tests)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('Lab Test / X-Ray Images') }}
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-6">
                    @foreach ($visit->lab_tests as $lab_img)
                        <a href="{{ asset('storage/' . $lab_img) }}" data-lightbox="lab-tests"
                            class="group relative block rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="aspect-w-1 aspect-h-1 w-full h-32 bg-gray-100">
                                <img src="{{ asset('storage/' . $lab_img) }}" alt="{{ $visit->service->name }}"
                                    class="w-full h-32 object-cover group-hover:opacity-90 transition-opacity duration-200">
                            </div>
                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if ($visit->notes)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border-l-4 border-primary">
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ __('Notes') }}
                        </label>
                        <div class="text-gray-800 leading-relaxed">{!! $visit->notes !!}</div>
                    </div>
                @endif
            </section>
        @endif

        <!-- Medicines Section -->
        @if ($visit->medicines_list)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    {{ __('Prescribed Medicines') }}
                </h3>
                <div class="flex flex-wrap gap-3">
                    @php
                        // Flatten and split comma-separated values
                        $medicines = collect((array) $visit->medicines_list)
                            ->flatMap(fn($item) => is_string($item) ? array_map('trim', explode(',', $item)) : [$item])
                            ->filter()
                            ->unique()
                            ->values();
                    @endphp
                    @foreach ($medicines as $medicine)
                        <span
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary/10 to-primary/5 text-primary font-medium rounded-full shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            {{ $medicine }}
                        </span>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Blood Pressure Section -->
        @if ($visit->sys || $visit->dia)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ __('Vital Signs') }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @if ($visit->sys)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                {{ __('Systolic') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->sys }}</div>
                        </div>
                    @endif

                    @if ($visit->dia)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                </svg>
                                {{ __('Diastolic') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->dia }}</div>
                        </div>
                    @endif

                    @if ($visit->pulse_rate)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ __('Pulse Rate') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->pulse_rate }}</div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- Anthropometric Measurements section --}}
        @if ($visit->weight || $visit->height || $visit->body_max_index)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1" />
                    </svg>
                    {{ __('Anthropometric Measurements') }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @if ($visit->weight)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1" />
                                </svg>
                                {{ __('Weight') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->weight }} <span
                                    class="text-sm font-medium text-gray-600">{{ __('kg') }}</span></div>
                        </div>
                    @endif

                    @if ($visit->height)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                {{ __('Height') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->height }} <span
                                    class="text-sm font-medium text-gray-600">{{ __('cm') }}</span></div>
                        </div>
                    @endif

                    @if ($visit->body_max_index)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                {{ __('BMI') }}
                            </label>
                            <div class="text-2xl font-bold text-gray-900">{{ $visit->body_max_index }} <span
                                    class="text-sm font-medium text-gray-600">{{ __('kg/m²') }}</span></div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- Dentist Examination Section -->
        @if ($visit->doctor_description || $visit->treatment)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Clinical Notes & Treatment') }}
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @if ($visit->doctor_description)
                        <div
                            class="bg-gradient-to-br from-primary/5 to-transparent rounded-xl p-5 border border-primary/20">
                            <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ __('Doctor Description') }}
                            </label>
                            <div class="prose prose-sm max-w-none text-gray-800 leading-relaxed">
                                {!! $visit->doctor_description !!}
                            </div>
                        </div>
                    @endif

                    @if ($visit->treatment)
                        <div class="bg-gradient-to-br from-green-50 to-transparent rounded-xl p-5 border border-green-200">
                            <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                {{ __('Treatment Plan') }}
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $treatments = collect((array) $visit->treatment)
                                        ->flatMap(
                                            fn($item) => is_string($item)
                                                ? array_map('trim', explode(',', $item))
                                                : [$item],
                                        )
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp
                                @foreach ($treatments as $item)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 font-medium rounded-full text-sm shadow-sm hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($visit->chief_complaint)
                        <div
                            class="bg-gradient-to-br from-yellow-50 to-transparent rounded-xl p-5 border border-yellow-200">
                            <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('chief complaint') }}
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $complaints = collect((array) $visit->chief_complaint)
                                        ->flatMap(
                                            fn($item) => is_string($item)
                                                ? array_map('trim', explode(',', $item))
                                                : [$item],
                                        )
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp
                                @foreach ($complaints as $item)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 font-medium rounded-full text-sm shadow-sm hover:bg-yellow-200 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($visit->medical_history)
                        <div
                            class="bg-gradient-to-br from-purple-50 to-transparent rounded-xl p-5 border border-purple-200">
                            <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                {{ __('Medical History') }}
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $history = collect((array) $visit->medical_history)
                                        ->flatMap(
                                            fn($item) => is_string($item)
                                                ? array_map('trim', explode(',', $item))
                                                : [$item],
                                        )
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp
                                @foreach ($history as $item)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 font-medium rounded-full text-sm shadow-sm hover:bg-purple-200 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                            <path fill-rule="evenodd"
                                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($visit->diagnosis)
                        <div
                            class="bg-gradient-to-br from-red-50 to-transparent rounded-xl p-5 border border-red-200 lg:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('diagnosis') }}
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $diagnoses = collect((array) $visit->diagnosis)
                                        ->flatMap(
                                            fn($item) => is_string($item)
                                                ? array_map('trim', explode(',', $item))
                                                : [$item],
                                        )
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp
                                @foreach ($diagnoses as $item)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 font-medium rounded-full text-sm shadow-sm hover:bg-red-200 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 5a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V9zm11-1a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1h-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $item }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- Secretary & Patient Interaction Section -->
        @if ($visit->secretary_description || $visit->patient_description)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-2.4-.322l-3.6 1.2 1.2-3.6A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z" />
                    </svg>
                    {{ __('Communication & Notes') }}
                </h3>

                @if ($visit->secretary_description)
                    <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            {{ __('Secretary Note to Patient') }}
                        </label>
                        <div class="prose prose-sm max-w-none text-gray-800 leading-relaxed">
                            {!! $visit->secretary_description !!}
                        </div>
                    </div>
                @endif

                <div class="p-5 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-200">
                    <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('Patient Comment / Description') }}
                    </label>
                    <div class="prose prose-sm max-w-none text-gray-800 leading-relaxed">
                        {!! $visit->patient_description !!}
                    </div>
                </div>

                @if ($visit->attachment)
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            {{ __('Attachment') }}
                        </label>
                        <a href="{{ asset('storage/' . $visit->attachment) }}"
                            class="inline-flex items-center gap-2 text-primary font-semibold hover:text-primary/80 transition-colors duration-200"
                            target="_blank">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            {{ __('View Attachment') }}
                        </a>
                    </div>
                @endif
            </section>
        @endif

        <!-- Related Services Table -->
        <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
            <h2 class="text-xl font-bold mb-6 text-primary flex items-center gap-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 11H5m14-7l-2 2m0 0l-2-2m2 2V3m2 4H5m14 10l-2-2m0 0l-2 2m2-2v2M9 3v2m3 0v2m3 0v2" />
                </svg>
                {{ __('Related Services') }}
            </h2>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="text-xs font-semibold text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center">{{ __('Service Name') }}</th>
                            <th scope="col" class="px-6 py-4 text-center">{{ __('QTY') }}</th>
                            <th scope="col" class="px-6 py-4 text-right">{{ __('Price') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if (isset($visit->relatedService) && $visit->relatedService->count() > 0)
                            @foreach ($visit->relatedService as $service)
                                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors duration-150">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap">
                                        {{ $service->relatedService->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-primary">
                                        {{ $service->qty }}
                                    </td>
                                    <td class="px-6 py-4 text-start font-medium text-gray-900">
                                        ${{ number_format($service->price_related_service, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">{{ __('No Related Services Found') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Visit Feedback -->
        @if ($visit->feedback)
            <section class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                <h3 class="text-xl font-bold mb-6 text-primary flex items-center gap-3 pb-4 border-b border-gray-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z" />
                    </svg>
                    {{ __('Visit Feedback') }}
                </h3>

                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                    <div class="flex flex-col items-center gap-4">
                        <div class="flex items-center gap-1 text-3xl">
                            @php
                                $rating = $visit->feedback->rating ?? 0;
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm font-medium text-gray-700">{{ __('Rating') }}: <span
                                class="font-bold">{{ $rating }}/5</span></p>
                    </div>

                    <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                        <label class="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4-4-4z" />
                            </svg>
                            {{ __('Feedback Comment') }}
                        </label>
                        <div class="text-gray-800 leading-relaxed">
                            {{ $visit->feedback->comments ?? __('No comment provided') }}
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

    <script src="{{ asset('js/lightbox-plus-jquery.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'disableScrolling': true,
        })
    </script>
@endsection
