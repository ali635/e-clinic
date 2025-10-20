@extends('patient.share.sidbar')
@section('patient_content')
<!-- Main Content -->
<main class="flex-1 px-4 py-8 md:ml-0 ml-0">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Profile</h2>
        <button 
            id="editProfileBtn"
            class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded hover:bg-primary/80 focus:outline-none"
        >
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036A2.5 2.5 0 1118.5 7.5L7 19H3v-4L15.732 3.732z"/>
            </svg>
            Edit
        </button>
    </div>

    <div class="">
        <!-- Profile Data -->
        <div id="profileDisplay" class="bg-white rounded-xl shadow p-6 animate-fade-in">
            <dl class="space-y-4">
                <div class="flex justify-between">
                    <dt class="font-medium">Name:</dt>
                    <dd class="text-end">{{ $patient->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">Phone:</dt>
                    <dd class="text-end">{{ $patient->phone ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">Date of Birth:</dt>
                    <dd class="text-end">{{ $patient->date_of_birth ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">Gender:</dt>
                    <dd class="text-end">{{ ucfirst($patient->gender ?? '-') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">City:</dt>
                    <dd class="text-end">{{ $patient->city->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="font-medium">Address:</dt>
                    <dd class="text-end">{{ $patient->address ?? '-' }}</dd>
                </div>
            </dl>
        </div>
        <!-- Profile Edit Form -->
        <form id="profileEditForm" 
            class="bg-white rounded-xl shadow p-6 animate-fade-in hidden mt-4"
            method="POST" 
            action=""
        >
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ $patient->name }}" class="form-input w-full" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="{{ $patient->phone }}" class="form-input w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}" class="form-input w-full">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Gender</label>
                <select name="gender" class="form-input w-full">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">City</label>
                <select name="city" class="form-input w-full">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Address</label>
                <input type="text" name="address" value="{{ $patient->address }}" class="form-input w-full">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-primary/80">Save</button>
                <button type="button" id="cancelEditProfileBtn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
            </div>
        </form>
    </div>
    <script>
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
    </script>
</main>
@endsection