@extends('patient.share.sidbar')
@section('patient_content')
    <link rel="stylesheet" href="{{ asset('css/intelTelInput.css') }}">

    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0">
        <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold flex items-center gap-2">
            {{ __('Profile') }}
            <span class="text-gray-600 text-sm">
                ({{ $stars }} 
                @for ($i = 0; $i < $stars; $i++)
                    <span class="text-[#ffd700] text-2xl">★</span>
                @endfor
                {{__('Stars Member')}})
            </span>
        </h2>            <button id="editProfileBtn"
                class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-primary/80 focus:outline-none">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036A2.5 2.5 0 1118.5 7.5L7 19H3v-4L15.732 3.732z" />
                </svg>
                {{ __('Update') }}
            </button>
        </div>

        <div class="">
            <!-- Profile Data -->
            <div id="profileDisplay" class="bg-white rounded-xl shadow p-6 animate-fade-in">
                <dl class="space-y-4">
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
                        <dd class="text-end">{{ Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium">{{ __('gender') }}:</dt>
                        <dd class="text-end">{{ ucfirst($patient->gender ?? '-') }}</dd>
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
                </dl>
            </div>
            <!-- Profile Edit Form -->
            <form id="profileEditForm" class="bg-white rounded-xl shadow p-6 animate-fade-in hidden mt-4" method="POST"
                action="{{ route('patient.update.profile') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('Name') }}</label>
                    <input type="text" name="name" value="{{ $patient->name }}" class="form-input w-full" required>
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium mb-1">{{ __('Phone') }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ $patient->phone }}" class="form-input w-full">
                    @error('phone')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="other_phone" class="block text-sm font-medium mb-1">{{ __('Other Phone') }}</label>
                    <input type="tel" id="other_phone" name="other_phone" value="{{ $patient->other_phone }}" class="form-input w-full">
                    @error('other_phone')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('Date of Birth') }}</label>
                    <input type="date" name="date_of_birth" value="{{  Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') }}"
                        class="form-input w-full">
                    @error('date_of_birth')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('gender') }}</label>
                    <select name="gender" class="form-input w-full">
                        <option value="">{{ __('Select') }}</option>
                        <option value="male" @if ($patient->gender == 'male') selected @endif>{{ __('Male') }}
                        </option>
                        <option value="female" @if ($patient->gender == 'female') selected @endif>{{ __('Female') }}
                        </option>
                    </select>
                    @error('gender')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium mb-1">{{ __('City') }}</label>
                    <select id="city" name="city" class="form-input w-full">
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if ($patient->city_id == $city->id) selected @endif>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="area" class="block text-sm font-medium mb-1">{{ __('Area') }}</label>
                    <select id="area" name="area" class="form-input w-full">
                        <option value="">{{ __('Select your area') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @if ($patient->area_id == $area->id) selected @endif>
                                {{ $area->name }}</option>
                        @endforeach
                    </select>
                    @error('area')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('address') }}</label>
                    <input type="text" name="address" value="{{ $patient->address }}" class="form-input w-full">
                    @error('address')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('hear about us') }}</label>
                    <input type="text" name="hear_about_us" value="{{ $patient->hear_about_us }}"
                        class="form-input w-full">
                    @error('hear_about_us')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
               
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('Diseases') }}</label>
                    @foreach ($diseases as $disease)
                        <div class="flex items-center">
                            <input type="checkbox" name="diseases[]" value="{{ $disease->id }}"
                                @if ($patient->diseasesMany->contains($disease->id)) checked @endif>
                            <span class="ms-2">{{ $disease->name }}</span>
                        </div>
                    @endforeach
                    @error('diseases')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded hover:bg-primary/80">{{ __('Save') }}</button>
                    <button type="button" id="cancelEditProfileBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">{{ __('Cancel') }}</button>
                </div>
            </form>
        </div>
        <script src="{{ asset('js/intelTelInput.js') }}"></script>
        <script>
            let currentLocale = "{{ app()->getLocale() }}";
            const editProfileBtn = document.querySelector('#editProfileBtn');
            const cancelEditProfileBtn = document.querySelector('#cancelEditProfileBtn');

            function toggleEditProfile() {
                const display = document.getElementById('profileDisplay');
                const form = document.getElementById('profileEditForm');
                let isEditing = form.classList.contains('hidden');
                form.classList.toggle('hidden', !isEditing);
                display.classList.toggle('hidden', isEditing);
            }
            editProfileBtn.addEventListener('click', toggleEditProfile);
            cancelEditProfileBtn.addEventListener('click', toggleEditProfile);


            const input = document.querySelector("#phone");
            window.intlTelInput(input, {
                loadUtils: () => import("{{ asset('js/intelUtilities.js') }}"),
            });

            const input2 = document.querySelector("#other_phone");
            window.intlTelInput(input2, {
                loadUtils: () => import("{{ asset('js/intelUtilities.js') }}"),
            });

            const city = document.querySelector("#city");
            city.addEventListener("change", function() {
                const cityId = this.value;
                const area = document.querySelector("#area");
                let optionsStr = `<option value="">{{ __('Select your area') }}</option>`;
                area.innerHTML = optionsStr;
                if(cityId){
                    fetch(`/api/v1/countries/${cityId}/areas?lang=${currentLocale}`)
                        .then(response => response.json())
                        .then(data => {
                            const areas = data?.data || [];
                            areas.forEach(area => {
                                optionsStr += `<option value="${area.id}">${area.name}</option>`;
                            });
                            area.innerHTML = optionsStr;
                        });
                }
            });
        </script>
    </main>
@endsection
