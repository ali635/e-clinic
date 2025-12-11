<section class="py-12 bg-white">
    <div class="container">
        <div class="flex flex-col tablet:flex-row tablet:justify-between tablet:items-center gap-2 mb-8">
            <h2 class="text-3xl tablet:text-4xl font-bold text-primary">
                {{ __('Our Services') }}
            </h2>
            <a href="{{ route('services') }}"
                class="text-primary self-end tablet:self-center border border-primary text-center px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition duration-300 ease-in-out">{{ __('All Services') }}</a>
        </div>
        <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-4">
            @foreach ($services as $service)
                <div
                    class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100 reveal-up">

                    <!-- Image Container -->
                    <div class="relative h-56 md:h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">

                        <!-- Overlay on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <!-- Badge for price -->
                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md">
                            <span class="text-sm font-bold text-gray-900">
                                {{ number_format($service->price, 0) }}
                                <span class="text-primary text-xs">{{ __('IQD') }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 md:p-7">
                        <h3
                            class="text-xl md:text-2xl font-bold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-300">
                            {{ $service->name }}
                        </h3>

                        <p class="text-sm md:text-base text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                            {!! Str::limit(strip_tags($service->short_description), 120) !!}
                        </p>

                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service->duration ?? __('45 min') }}
                            </div>

                            @if ($service->slug)
                                <a href="{{ route('service.show', $service->slug) }}"
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-primary/90 text-white px-4 py-2.5 rounded-full text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300 group/book">
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover/book:translate-x-1"
                                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Book Service') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
