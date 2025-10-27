@extends('patient.share.sidbar')
@section('patient_content')
    <link rel="stylesheet" crossorigin href="{{ asset('css/lightbox.css') }}">
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0 overflow-x-auto">

        <!-- Visit Details Header -->
        <section class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-3 text-primary flex items-center">
                <svg class="inline me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11V17H13V11H11ZM11 7V9H13V7H11Z">
                    </path>
                </svg>
                {{ __('Visit Details') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="mb-2"><span class="font-semibold text-gray-700">{{ __('Patient Name') }}:</span>
                        {{ $patient->name }}</p>
                    <p class="mb-2"><span class="font-semibold text-gray-700">{{ __('Service') }}:</span>
                        {{ $visit->service->name }}</p>
                    <p class="mb-2">
                        <span class="font-semibold text-gray-700">{{ __('Arrived') }}:</span>
                        <!-- if arrived -->
                        @if ($visit->is_arrival)
                            <span class="text-primary font-bold">{{ __('Yes') }}</span>
                            <span class="ml-2 text-gray-700" style="font-size: 0.95em;">
                                ({{ __('Arrival Time') }}:
                                {{ $visit->arrival_time }})
                            </span>
                        @else
                            <span class="text-red-500 font-bold">{{__('No')}}</span>
                        @endif

                        <!-- else -->
                    </p>
                </div>
                <div>
                    <p class="mb-2">
                        <span class="font-semibold text-gray-700">{{ __('Date/Time') }}:</span>
                        {{ \Carbon\Carbon::parse($visit->arrival_time)->format('Y-m-d h:i A') }}
                    </p> {{-- <p class="mb-2"><span class="font-semibold text-gray-700">Time:</span> 10:00 AM</p> --}}
                    <p class="mb-2">
                        <span class="font-semibold text-gray-700">{{ __('Total Price') }}:</span>
                        125 IQD
                    </p>
                </div>
            </div>
        </section>

        <!-- Lab Test Images Section -->
        @if ($visit->lab_tests)
            <section class="bg-white rounded-xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-3 text-primary flex items-center">
                    <svg class="inline me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M15.9994 2V4H14.9994V7.24291C14.9994 8.40051 15.2506 9.54432 15.7357 10.5954L20.017 19.8714C20.3641 20.6236 20.0358 21.5148 19.2836 21.8619C19.0865 21.9529 18.8721 22 18.655 22H5.34375C4.51532 22 3.84375 21.3284 3.84375 20.5C3.84375 20.2829 3.89085 20.0685 3.98181 19.8714L8.26306 10.5954C8.74816 9.54432 8.99939 8.40051 8.99939 7.24291V4H7.99939V2H15.9994ZM13.3873 10.0012H10.6115C10.5072 10.3644 10.3823 10.7221 10.2371 11.0724L10.079 11.4335L6.12439 20H17.8734L13.9198 11.4335C13.7054 10.9691 13.5276 10.4902 13.3873 10.0012ZM10.9994 7.24291C10.9994 7.49626 10.9898 7.7491 10.9706 8.00087H13.0282C13.0189 7.87982 13.0119 7.75852 13.0072 7.63704L12.9994 7.24291V4H10.9994V7.24291Z">
                        </path>
                    </svg>
                    {{ __('Lab Test Images') }}
                </h3>
                <div class="flex flex-wrap gap-4">
                    @foreach ($visit->lab_tests as $lab_img)
                        <div
                            class="w-32 h-32 rounded overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50 shadow">
                            <a href="{{ asset('storage/' . $lab_img) }}" data-lightbox="lab-tests">
                                <img src="{{ asset('storage/' . $lab_img) }}" alt="{{ $visit->service->name }}"
                                    class="max-w-full max-h-full object-cover">
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif


        <!-- X-Ray Images Section -->
        @if ($visit->x_rays)
            <section class="bg-white rounded-xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-3 text-primary flex items-center">
                    <svg class="inline me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px"
                        fill="currentColor">
                        <path
                            d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-560H200v560Zm160 0v-72l-72-84q-11-11-19.5-30t-8.5-44q0-13 2.5-25.5T271-440q-5-11-8-23.5t-3-26.5q0-25 8.5-44t19.5-30l72-84v-72h60v83q0 5-7 19l-80 94q-7 8-10 16.5t-3 17.5q0 20 13 34.5t33 14.5q9 0 17-3t14-10q17-17 38.5-26t44.5-9q23 0 44.5 9t38.5 26q7 7 15 10t16 3q20 0 33-14.5t13-33.5q0-9-3.5-17.5T627-523l-80-95q-4-4-5.5-9t-1.5-10v-83h60v72l73 86q14 16 20.5 34.5T700-489q0 13-3.5 25.5T688-440q6 12 9 24.5t3 25.5q0 25-8.5 44T672-316l-72 84v72h-60v-83q0-6 7-19l80-94q7-8 10-17t3-18q-11 5-22 7.5t-23 2.5q-20 0-40-8t-35-24q-7-8-17.5-12t-22.5-4q-11 0-21.5 4T440-413q-15 16-34.5 24t-39.5 8q-12 0-23.5-2.5T320-391q0 9 3 18t10 17l80 94q3 5 5 9.5t2 9.5v83h-60Zm-160 0v-560 560Z" />
                    </svg>
                    {{ __('X-Ray Images') }}
                </h3>
                <div class="flex flex-wrap gap-4">
                    @foreach ($visit->x_rays as $ray_img)
                        <div
                            class="w-32 h-32 rounded overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50 shadow">
                            <a href="{{ asset('storage/' . $ray_img) }}" data-lightbox="x-rays">
                                <img src="{{ asset('storage/' . $ray_img) }}" alt="{{ $visit->service->name }}"
                                    class="max-w-full max-h-full object-cover">
                            </a>
                        </div>
                    @endforeach

                </div>
            </section>
        @endif

        <!-- Dentist Examination Section -->
        @if ($visit->doctor_description || $visit->treatment)
            <section class="bg-white rounded-xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-3 text-primary flex items-center">
                    <svg class="inline me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M8 3V5H6V9C6 11.2091 7.79086 13 10 13C12.2091 13 14 11.2091 14 9V5H12V3H15C15.5523 3 16 3.44772 16 4V9C16 11.9727 13.8381 14.4405 11.0008 14.9169L11 16.5C11 18.433 12.567 20 14.5 20C15.9973 20 17.275 19.0598 17.7749 17.7375C16.7283 17.27 16 16.2201 16 15C16 13.3431 17.3431 12 19 12C20.6569 12 22 13.3431 22 15C22 16.3711 21.0802 17.5274 19.824 17.8854C19.2102 20.252 17.0592 22 14.5 22C11.4624 22 9 19.5376 9 16.5L9.00019 14.9171C6.16238 14.4411 4 11.9731 4 9V4C4 3.44772 4.44772 3 5 3H8ZM19 14C18.4477 14 18 14.4477 18 15C18 15.5523 18.4477 16 19 16C19.5523 16 20 15.5523 20 15C20 14.4477 19.5523 14 19 14Z">
                        </path>
                    </svg>
                    {{ __('Doctor Examination & Prescription') }}
                </h3>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Examination Result') }}</label>
                    <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                        {!! $visit->doctor_description !!}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Medicines') }}</label>
                    <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                        {!! $visit->treatment !!}
                    </div>
                </div>
            </section>
        @endif

        <!-- Secretary & Patient Interaction Section -->
        @if ($visit->secretary_description || $visit->patient_description)
            <section class="bg-white rounded-xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-3 text-primary flex items-center">
                    <svg class="inline me-2" width="20px" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.7 0 8 1.35 8 4.06v1.44A2.5 2.5 0 0 1 17.5 20h-11A2.5 2.5 0 0 1 4 17.5v-1.44C4 13.35 9.3 12 12 12zm0-3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg>
                    {{ __('Secretary & Patient Notes & Attachments') }}
                </h3>
                @if ($visit->secretary_description)
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">{{ __('Secretary Note to Patient') }}</label>
                        <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                            {!! $visit->secretary_description !!}
                        </div>
                    </div>
                @endif
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Patient Comment / Description') }}</label>
                    <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                        {!! $visit->patient_description !!}
                    </div>
                </div>
                @if ($visit->attachment)
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">{{ 'Attachment' }}</label>
                        <ul class="list-disc ms-6 text-primary mt-2 mb-0 text-sm space-y-1">
                            <li>
                                <a href="{{ asset('storage/' . $visit->attachment) }}"
                                    class="underline hover:text-primary/60" target="_blank">{{ __('attachment') }}</a>
                            </li>
                        </ul>
                    </div>
                @endif

            </section>
        @endif

        <section class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-6">{{ __('Related Services') }}</h2>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Service name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Total Price') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($visits) && $visits->count() > 0)
                            @foreach ($visits as $visit)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $visit->service->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $visit->total_price ?? $visit->price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('patient.visits.show', $visit->id) }}" class="font-medium text-primary hover:opacity-60">
                                            <svg width="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-xl">
                                    <svg class="inline-block" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path></svg>
                                    {{ __('No Related visits found') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

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
