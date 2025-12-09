@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0">
        @include('patient.profile.button-menu', compact('stars'))


        <div class="">
            <!-- Profile Data -->
            <div id="profileDisplay" class="bg-white rounded-xl shadow p-6 animate-fade-in">
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <!-- <dt class="font-medium">{{ __('Image') }}:</dt> -->
                        <dd class="text-end">
                            <img onerror="this.src={{ asset('storage/' . setting('site_logo')) }}"
                                src="{{ asset('storage/' . $patient->img_profile) }}" alt="{{ $patient->name }}"
                                class="w-16 h-16 rounded-full">
                            {{-- @if ($patient->img_profile)
                            @else
                                <span class="text-gray-400">{{ __('No image') }}</span>
                            @endif --}}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Name') }}:</dt>
                        <dd class="text-end">{{ $patient->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Phone') }}:</dt>
                        <dd class="text-end">{{ $patient->phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Other Phone') }}:</dt>
                        <dd class="text-end">{{ $patient->other_phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Date of Birth') }}:</dt>
                        <dd class="text-end">{{ Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') ?? '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('gender') }}:</dt>
                        <dd class="text-end">{{ ucfirst($patient->gender ?? '-') }}</dd>
                    </div>

                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('marital status') }}:</dt>
                        <dd class="text-end">{{ ucfirst($patient->marital_status ?? '-') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('City') }}:</dt>
                        <dd class="text-end">{{ $patient->city->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Area') }}:</dt>
                        <dd class="text-end">{{ $patient->area->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('address') }}:</dt>
                        <dd class="text-end">{{ $patient->address ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Referral') }}:</dt>
                        <dd class="text-end">{{ $patient->referral->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('Hear About Us') }}:</dt>
                        <dd class="text-end">{{ $patient->hear_about_us ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
            <!-- Profile Edit Form -->

        </div>

    </main>
@endsection
