@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M Medical
    System.'))
@section('keywords', __('Dr Azad Hasan, clinic services, healthcare, booking, doctors, appointments, medical system, 3M
    services'))
@section('og_title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('og_description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M
    Medical System.'))
@section('og_type', 'website')
@section('twitter_title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('twitter_description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M
    Medical System.'))

@section('content')
    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-primary to-blue-600 px-8 py-10 text-white">
                <h1 class="text-4xl font-bold mb-2">{{ __('Privacy Policy') }}</h1>
                <p class="text-blue-100 opacity-90">{{ __('Last updated: January 2026') }}</p>
            </div>

            <div class="p-8 space-y-8 text-gray-700 leading-relaxed">
                {{-- Introduction --}}
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 border-b pb-2">{{ __('1. Introduction') }}</h2>
                    <p>
                        {{ __('Welcome to') }} <span class="font-semibold text-primary">{{ setting('site_name') }}</span>.
                        {{ __('We are committed to protecting your personal and medical information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our clinic management system and services.') }}
                    </p>
                </section>

                {{-- Information Collection --}}
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 border-b pb-2">{{ __('2. Information We Collect') }}</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Personal Data') }}</h3>
                            <ul class="list-disc list-inside space-y-1 ml-4">
                                <li>{{ __('Identity: Full name, gender, and date of birth.') }}</li>
                                <li>{{ __('Contact: Phone number, email address, and physical address.') }}</li>
                                <li>{{ __('Location: City and area information for service accessibility.') }}</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Health & Medical Data') }}</h3>
                            <ul class="list-disc list-inside space-y-1 ml-4">
                                <li>{{ __('Visit Records: Appointment history, symptoms, and chief complaints.') }}</li>
                                <li>{{ __('Clinical Notes: Vital signs (BP, Pulse), doctor observations, and diagnoses.') }}</li>
                                <li>{{ __('Prescriptions: Medicine lists and treatment plans.') }}</li>
                                <li>{{ __('Diagnostic Media: Laboratory test results and imaging (X-rays) attachments.') }}</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- Use of Information --}}
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 border-b pb-2">{{ __('3. How We Use Your Information') }}</h2>
                    <p class="mb-4">
                        {{ __('We use the collected information for various purposes centered on your healthcare:') }}
                    </p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>{{ __('Booking and managing medical appointments.') }}</li>
                        <li>{{ __('Providing accurate diagnoses and tailored treatment plans.') }}</li>
                        <li>{{ __('Generating prescriptions and tracking medical history for follow-ups.') }}</li>
                        <li>{{ __('Utilizing AI-assisted analysis to enhance diagnostic accuracy.') }}</li>
                        <li>{{ __('Sending appointment reminders and health-related notifications via Firebase.') }}</li>
                    </ul>
                </section>

                {{-- Data Security --}}
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 border-b pb-2">{{ __('4. Data Security & Storage') }}</h2>
                    <p>
                        {{ __('Your data security is our highest priority. We implement robust technical and organizational measures to protect your medical records from unauthorized access, alteration, or disclosure. Medical data is stored securely and only accessible by authorized medical staff involved in your care.') }}
                    </p>
                </section>

                {{-- User Rights --}}
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 border-b pb-2">{{ __('5. Your Rights') }}</h2>
                    <p>
                        {{ __('You have the right to access your medical records, request corrections to inaccurate data, and inquire about how your information is being handled. For any requests regarding your data portability or deletion, please contact our administrative office.') }}
                    </p>
                </section>

                {{-- Contact Information --}}
                <section class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('6. Contact Us') }}</h2>
                    <p class="mb-4">{{ __('If you have any questions about this Privacy Policy, please contact us:') }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(setting('site_email'))
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm">{{ setting('site_email') }}</span>
                        </div>
                        @endif
                        @if(setting('site_phone'))
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <span class="text-sm">{{ setting('site_phone') }}</span>
                        </div>
                        @endif
                    </div>
                    @if(setting_lang('address'))
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-start gap-3 text-gray-600">
                            <svg class="w-5 h-5 text-primary mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-sm">{!! setting_lang('address') !!}</span>
                        </div>
                    </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection

