@extends('patient.share.sidbar')
@section('patient_content')
<main class="flex-1 px-4 py-8 md:ml-0 ml-0 overflow-x-auto">

    <!-- Visit Details Header -->
    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-primary">Visit Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="mb-2"><span class="font-semibold text-gray-700">Patient Name:</span> John Doe</p>
                <p class="mb-2"><span class="font-semibold text-gray-700">Service:</span> Dental Cleaning</p>
                <p class="mb-2">
                    <span class="font-semibold text-gray-700">Arrived:</span> 
                    <!-- if arrived -->
                    <span class="text-green-500 font-bold">Yes</span>
                    <span class="ml-2 text-gray-700" style="font-size: 0.95em;">
                        (Arrival Time: 09:50 AM)
                    </span>
                    <!-- else -->
                    <span class="text-red-500 font-bold">No</span>
                </p>
            </div>
            <div>
                <p class="mb-2"><span class="font-semibold text-gray-700">Date:</span> 2024-06-20</p>
                <p class="mb-2"><span class="font-semibold text-gray-700">Time:</span> 10:00 AM</p>
            </div>
        </div>
    </section>

    <!-- Lab Test Images Section -->
    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-3 text-blue-600 flex items-center">
            <svg class="inline me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M15.9994 2V4H14.9994V7.24291C14.9994 8.40051 15.2506 9.54432 15.7357 10.5954L20.017 19.8714C20.3641 20.6236 20.0358 21.5148 19.2836 21.8619C19.0865 21.9529 18.8721 22 18.655 22H5.34375C4.51532 22 3.84375 21.3284 3.84375 20.5C3.84375 20.2829 3.89085 20.0685 3.98181 19.8714L8.26306 10.5954C8.74816 9.54432 8.99939 8.40051 8.99939 7.24291V4H7.99939V2H15.9994ZM13.3873 10.0012H10.6115C10.5072 10.3644 10.3823 10.7221 10.2371 11.0724L10.079 11.4335L6.12439 20H17.8734L13.9198 11.4335C13.7054 10.9691 13.5276 10.4902 13.3873 10.0012ZM10.9994 7.24291C10.9994 7.49626 10.9898 7.7491 10.9706 8.00087H13.0282C13.0189 7.87982 13.0119 7.75852 13.0072 7.63704L12.9994 7.24291V4H10.9994V7.24291Z"></path></svg>
            Lab Test Images
        </h3>
        <div class="flex flex-wrap gap-4">
            <div class="w-32 h-32 rounded overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50 shadow">
                <img src="https://via.placeholder.com/120x120?text=Lab+Test+1" alt="Lab Test 1" class="max-w-full max-h-full object-cover">
            </div>
            <div class="w-32 h-32 rounded overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50 shadow">
                <img src="https://via.placeholder.com/120x120?text=Lab+Test+2" alt="Lab Test 2" class="max-w-full max-h-full object-cover">
            </div>
        </div>
    </section>

    <!-- X-Ray Images Section -->
    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-3 text-blue-600 flex items-center">
            <svg class="inline me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-560H200v560Zm160 0v-72l-72-84q-11-11-19.5-30t-8.5-44q0-13 2.5-25.5T271-440q-5-11-8-23.5t-3-26.5q0-25 8.5-44t19.5-30l72-84v-72h60v83q0 5-7 19l-80 94q-7 8-10 16.5t-3 17.5q0 20 13 34.5t33 14.5q9 0 17-3t14-10q17-17 38.5-26t44.5-9q23 0 44.5 9t38.5 26q7 7 15 10t16 3q20 0 33-14.5t13-33.5q0-9-3.5-17.5T627-523l-80-95q-4-4-5.5-9t-1.5-10v-83h60v72l73 86q14 16 20.5 34.5T700-489q0 13-3.5 25.5T688-440q6 12 9 24.5t3 25.5q0 25-8.5 44T672-316l-72 84v72h-60v-83q0-6 7-19l80-94q7-8 10-17t3-18q-11 5-22 7.5t-23 2.5q-20 0-40-8t-35-24q-7-8-17.5-12t-22.5-4q-11 0-21.5 4T440-413q-15 16-34.5 24t-39.5 8q-12 0-23.5-2.5T320-391q0 9 3 18t10 17l80 94q3 5 5 9.5t2 9.5v83h-60Zm-160 0v-560 560Z"/></svg>
            X-Ray Images
        </h3>
        <div class="flex flex-wrap gap-4">
            <div class="w-32 h-32 rounded overflow-hidden border border-gray-200 flex items-center justify-center bg-gray-50 shadow">
                <img src="https://via.placeholder.com/120x120?text=X-Ray+1" alt="X-Ray 1" class="max-w-full max-h-full object-cover">
            </div>
        </div>
    </section>

    <!-- Dentist Examination Section -->
    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-3 text-blue-700 flex items-center">
            <svg class="inline me-2" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 3V5H6V9C6 11.2091 7.79086 13 10 13C12.2091 13 14 11.2091 14 9V5H12V3H15C15.5523 3 16 3.44772 16 4V9C16 11.9727 13.8381 14.4405 11.0008 14.9169L11 16.5C11 18.433 12.567 20 14.5 20C15.9973 20 17.275 19.0598 17.7749 17.7375C16.7283 17.27 16 16.2201 16 15C16 13.3431 17.3431 12 19 12C20.6569 12 22 13.3431 22 15C22 16.3711 21.0802 17.5274 19.824 17.8854C19.2102 20.252 17.0592 22 14.5 22C11.4624 22 9 19.5376 9 16.5L9.00019 14.9171C6.16238 14.4411 4 11.9731 4 9V4C4 3.44772 4.44772 3 5 3H8ZM19 14C18.4477 14 18 14.4477 18 15C18 15.5523 18.4477 16 19 16C19.5523 16 20 15.5523 20 15C20 14.4477 19.5523 14 19 14Z"></path></svg>
            Dentist Examination & Prescription
        </h3>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Examination Result</label>
            <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                I have a question about the fasting requirement before the test.
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Medicines</label>
            <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                I have a question about the fasting requirement before the test.
            </div>
        </div>
    </section>

    <!-- Secretary & Patient Interaction Section -->
    <section class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-3 text-violet-700 flex items-center">
            <svg class="inline me-2" width="20px" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.35 8 4.06v1.44A2.5 2.5 0 0 1 17.5 20h-11A2.5 2.5 0 0 1 4 17.5v-1.44C4 13.35 9.3 12 12 12zm0-3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
            Secretary & Patient Notes & Attachments
        </h3>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Secretary Note to Patient</label>
            <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                The patient should fast for 8 hours before the blood test appointment.
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Patient Comment / Description</label>
            <div class="bg-gray-50 rounded p-3 border text-gray-800 shadow-inner min-h-[48px]">
                I have a question about the fasting requirement before the test.
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Attachments</label>
            <ul class="list-disc ms-6 text-blue-700 mt-2 mb-0 text-sm space-y-1">
                <li>
                    <a href="#" class="underline hover:text-blue-900" target="_blank">blood-test-instructions.pdf</a>
                </li>
                <li>
                    <a href="#" class="underline hover:text-blue-900" target="_blank">insurance_card.jpg</a>
                </li>
            </ul>
        </div>
    </section>
    
</main>
@endsection