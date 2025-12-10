@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        @include('patient.profile.button-menu', compact('stars'))

        <!-- Profile Edit Form -->
        <div class="max-w-5xl mx-auto">
            <form id="profileEditForm" class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 sm:p-8 animate-fade-in" method="POST"
                action="{{ route('patient.profile.update') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <!-- Name & Email Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $patient->name) }}" 
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3" 
                                required>
                            @error('name')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Email') }}</label>
                            <input type="email" name="email" value="{{ old('email', $patient->email) }}"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                                required>
                            @error('email')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Numbers Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Phone') }}</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            @error('phone')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label for="other_phone" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Other Phone') }}</label>
                            <input type="tel" id="other_phone" name="other_phone" value="{{ old('other_phone', $patient->other_phone) }}"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            @error('other_phone')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Date of Birth & Gender Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Date of Birth') }}</label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $patient->date_of_birth ? Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') : '') }}"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                            @error('date_of_birth')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Gender') }}</label>
                            <select name="gender"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                                <option value="">{{ __('Select Gender') }}</option>
                                <option value="male" @selected(old('gender', $patient->gender) == 'male')>{{ __('Male') }}</option>
                                <option value="female" @selected(old('gender', $patient->gender) == 'female')>{{ __('Female') }}</option>
                            </select>
                            @error('gender')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Marital Status & Address Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Marital Status') }}</label>
                            <select name="marital_status"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="single" @selected(old('marital_status', $patient->marital_status) == 'single')>{{ __('Single') }}</option>
                                <option value="married" @selected(old('marital_status', $patient->marital_status) == 'married')>{{ __('Married') }}</option>
                                <option value="divorced" @selected(old('marital_status', $patient->marital_status) == 'divorced')>{{ __('Divorced') }}</option>
                                <option value="widowed" @selected(old('marital_status', $patient->marital_status) == 'widowed')>{{ __('Widowed') }}</option>
                            </select>
                            @error('marital_status')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Address') }}</label>
                            <input type="text" name="address" value="{{ old('address', $patient->address) }}"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3"
                                placeholder="{{ __('Enter your address') }}">
                            @error('address')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- City & Area Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="city" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('City') }}</label>
                            <select id="city" name="city"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                                <option value="">{{ __('Select City') }}</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city', $patient->city_id) == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label for="area" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Area') }}</label>
                            <select id="area" name="area"
                                class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:ring-offset-0 transition-colors duration-200 px-4 py-3">
                                <option value="">{{ __('Select Area') }}</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" @selected(old('area', $patient->area_id) == $area->id)>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('area')
                                <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label for="img_profile" class="block text-sm font-semibold text-gray-800 mb-2">
                            {{ __('Profile Image') }}
                        </label>
                        <div class="relative">
                            <input id="img_profile" type="file" name="img_profile"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer transition-colors duration-200">
                        </div>
                        @error('img_profile')
                            <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Diseases Section -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">{{ __('Diseases') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 p-4 bg-gray-50 rounded-lg">
                            @foreach ($diseases as $disease)
                                <label class="flex items-center p-2 rounded-md hover:bg-white cursor-pointer transition-colors duration-150">
                                    <input type="checkbox" name="diseases[]" value="{{ $disease->id }}"
                                        @checked(old('diseases') ? in_array($disease->id, old('diseases')) : $patient->diseasesMany->contains($disease->id))
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20 focus:ring-offset-0">
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $disease->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('diseases')
                            <div class="mt-2 text-red-600 text-sm font-medium bg-red-50 rounded-md px-3 py-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-primary to-primary/80 text-white font-semibold rounded-lg hover:from-primary/90 hover:to-primary/70 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Save Changes') }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection