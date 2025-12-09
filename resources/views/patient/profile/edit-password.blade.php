@extends('patient.share.sidbar')
@section('patient_content')
    <!-- Main Content -->
    <main class="flex-1 px-4 py-8 md:ml-0 ml-0">
              @include('patient.profile.button-menu', compact('stars'))


        <div class="">
           
            <!-- Profile Edit Form -->
            <form id="profileEditForm" class="bg-white rounded-xl shadow p-6 animate-fade-in mt-4" method="POST"
                action="{{ route('patient.profile.update.password') }}">
                @csrf
                
               
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

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded hover:bg-primary/80">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
      
    </main>
@endsection
