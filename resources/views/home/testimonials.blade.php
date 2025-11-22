{{-- Testimonials Section --}}
<section class="py-16 bg-gray-50">
    <div class="container">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                {{ __('What Our Patients Say') }}
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('Real feedback from our valued patients') }}
            </p>
        </div>

        @if($feedbacks && $feedbacks->count() > 0)
            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 tablet:grid-cols-3 web:grid-cols-4 gap-6">
                @foreach($feedbacks as $feedback)
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                        {{-- Patient Avatar & Name --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-lg font-bold">
                                    {{ strtoupper(substr($feedback->patient->name ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 truncate">
                                    {{ $feedback->patient->name ?? __('Anonymous') }}
                                </h4>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $feedback->visit->service->name ?? __('General Service') }}
                                </p>
                            </div>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $feedback->rating)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>

                        {{-- Comment --}}
                        <p class="text-gray-700 text-sm leading-relaxed line-clamp-4">
                            "{{ $feedback->comments }}"
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">{{ __('No testimonials available yet.') }}</p>
            </div>
        @endif
    </div>
</section>
