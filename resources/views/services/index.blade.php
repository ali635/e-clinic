@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M Medical System.'))
@section('keywords', __('Dr Azad Hasan, clinic services, healthcare, booking, doctors, appointments, medical system, 3M services'))
@section('og_title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('og_description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M Medical System.'))
@section('og_type', 'website')
@section('twitter_title', __('Dr Azad Hasan Clinic Services - 3M Medical System'))
@section('twitter_description', __('Explore all our healthcare and clinic services. Book your appointment easily with 3M Medical System.'))

@section('content')
    <section class="py-16 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
        <div class="absolute inset-0 bg-white/50"></div>
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 relative inline-block">
                    {{ __('Our Services') }}
                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-primary to-primary/60 rounded-full"></span>
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('Here are our services choose from them') }}
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse ($services as $service)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100 reveal-up">
                        
                        <!-- Image Container -->
                        <div class="relative h-56 md:h-64 overflow-hidden">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->name }}"
                                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            
                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Badge for price -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md">
                                <span class="text-sm font-bold text-gray-900">
                                    {{ number_format($service->price, 0) }}
                                    <span class="text-primary text-xs">{{ __('IQD') }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 md:p-7">
                            <h3 class="text-xl md:text-2xl font-bold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-300">
                                {{ $service->name }}
                            </h3>
                            
                            <p class="text-sm md:text-base text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                {!! Str::limit(strip_tags($service->short_description), 120) !!}
                            </p>
                            
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $service->duration ?? __('45 min') }}
                                </div>
                                
                                @if ($service->slug)
                                    <a href="{{ route('service.show', $service->slug) }}"
                                       class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary/90 text-white px-4 py-2.5 rounded-full text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300 group/book">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/book:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ __('Book Service') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-200">
                            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14-7l-2 2m0 0l-2-2m2 2V3m2 4H5m14 10l-2-2m0 0l-2 2m2-2v2M9 3v2m3 0v2m3 0v2"/>
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700 mb-3">{{ __('No Services Available') }}</h3>
                            <p class="text-gray-500 text-lg max-w-md mx-auto">{{ __('We are currently updating our service offerings. Please check back soon.') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-md p-4">
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection