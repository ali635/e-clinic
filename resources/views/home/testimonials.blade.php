{{-- Testimonials Section --}}
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
    <div class="absolute inset-0 bg-white/40"></div>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 relative inline-block">
                {{ __('What Our Patients Say') }}
                <span
                    class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-gradient-to-r from-primary to-primary/60 rounded-full"></span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ __('Real feedback from our valued patients') }}
            </p>
        </div>

        @if ($feedbacks && $feedbacks->count() > 0)
            {{-- Testimonials Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach ($feedbacks as $feedback)
                    <div
                        class="relative bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200 overflow-hidden group reveal-up">

                        <!-- Decorative Quote -->
                        <div
                            class="absolute top-4 end-4 text-primary/20 group-hover:text-primary/40 transition-colors duration-300">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>

                        <!-- Patient Avatar & Name -->
                        <div class="flex items-center gap-4 mb-6 relative z-10">
                            <div
                                class="w-14 h-14 rounded-full bg-gradient-to-br from-primary/10 to-primary/20 flex items-center justify-center flex-shrink-0 shadow-md group-hover:scale-110 transition-transform duration-300">
                                <span class="text-primary text-xl font-bold">
                                    {{ strtoupper(substr($feedback->patient->name ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="text-lg font-bold text-gray-900 truncate group-hover:text-primary transition-colors duration-300">
                                    {{ $feedback->patient->name ?? __('Anonymous') }}
                                </h4>
                                <p class="text-sm text-gray-600 truncate">
                                    {{ $feedback->visit->service->name ?? __('General Service') }}
                                </p>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 mb-5 relative z-10">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $feedback->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }} transition-all duration-200"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>

                        <!-- Comment -->
                        <p class="text-gray-700 text-sm leading-relaxed relative z-10 italic">
                            "{{ $feedback->comments }}"
                        </p>

                        <!-- Bottom Gradient Bar -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <div class="bg-white/50 rounded-2xl p-12 backdrop-blur-sm">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-6 opacity-50" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('No Testimonials Yet') }}</h3>
                    <p class="text-gray-500 text-lg max-w-md mx-auto">
                        {{ __('Be the first to share your experience with us!') }}</p>
                </div>
            </div>
        @endif
    </div>
</section>
