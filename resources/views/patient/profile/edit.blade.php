@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0">
       @include('patient.profile.button-menu', compact('stars'))

        <div class="">
           
            <!-- Profile Edit Form -->
            <form id="profileEditForm" class="bg-white rounded-xl shadow p-6 animate-fade-in mt-4" method="POST"
                action="{{ route('patient.profile.update') }}">
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
                    <label class="block text-sm font-medium mb-1">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ $patient->email }}" class="form-input w-full" required>
                    @error('email')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium mb-1">{{ __('Phone') }}</label>
                    <input type="tel" id="phone" name="phone" value="{{ $patient->phone }}"
                        class="form-input w-full">
                    @error('phone')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="other_phone" class="block text-sm font-medium mb-1">{{ __('Other Phone') }}</label>
                    <input type="tel" id="other_phone" name="other_phone" value="{{ $patient->other_phone }}"
                        class="form-input w-full">
                    @error('other_phone')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('Date of Birth') }}</label>
                    <input type="date" name="date_of_birth"
                        value="{{ Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d') }}"
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
                    <label class="block text-sm font-medium mb-1">{{ __('marital status') }}</label>
                    <select name="marital_status" class="form-input w-full">
                        <option value="">{{ __('Select') }}</option>
                        <option value="single" @if ($patient->marital_status == 'single') selected @endif>{{ __('Single') }}
                        </option>
                        <option value="married" @if ($patient->marital_status == 'married') selected @endif>{{ __('Married') }}
                        </option>
                        <option value="divorced" @if ($patient->marital_status == 'divorced') selected @endif>{{ __('Divorced') }}
                        </option>
                        <option value="widowed" @if ($patient->marital_status == 'widowed') selected @endif>{{ __('Widowed') }}
                        </option>
                    </select>
                    @error('marital_status')
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
                    <label class="block text-sm font-medium mb-1">{{ __('old password') }}</label>
                    <input type="password" name="old_password" class="form-input w-full">
                    @error('old_password')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('new password') }}</label>
                    <input type="password" name="password" class="form-input w-full">
                    @error('password')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ __('confirm new password') }}</label>
                    <input type="password" name="password_confirmation" class="form-input w-full">
                    @error('password_confirmation')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>



                <div class="space-y-2">
                    <label for="street" class="block text-sm font-medium text-gray-700">
                        {{ __('image profile') }}
                    </label>
                    <input id="img_profile" type="file" name="img_profile"  class="form-input"
                        placeholder="{{ __('Enter img_profile') }}" value="{{ old('img_profile') }}">
                    @error('img_profile')
                        <div class="text-red-600 text-sm mt-1 ">
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
      
    </main>
@endsection
