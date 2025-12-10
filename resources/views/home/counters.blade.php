<section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
    <div class="absolute inset-0 bg-white/40"></div>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 relative inline-block">
                {{ __('Our Results Numbers') }}
                <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-primary to-primary/60 rounded-full"></span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ __('Numbers that speak for themselves') }}
            </p>
        </div>

        @if (setting_lang('counter_settings'))
            <div id="funFactsSection" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach (setting_lang('counter_settings') as $counter)
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 text-center group">
                        
                        <!-- Icon -->
                        <div class="mx-auto mb-6 w-20 h-20 rounded-full bg-gradient-to-br from-primary/10 to-primary/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>

                        <!-- Counter -->
                        <div class="flex items-center justify-center gap-1 mb-2">
                            <span class="text-4xl md:text-5xl font-bold text-gray-900 counter" data-target="{{ $counter['number_vendor'] ?? 0 }}">
                                0
                            </span>
                            <span class="text-3xl md:text-4xl font-bold text-primary">
                                +
                            </span>
                        </div>
                        
                        <!-- Label -->
                        <p class="text-gray-700 text-lg font-semibold">
                            {{ $counter['vendor'] }}
                        </p>
                        
                        <!-- Subtle animation indicator -->
                        <div class="mt-4 h-1 w-16 mx-auto bg-gradient-to-r from-primary to-transparent rounded-full"></div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6 opacity-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('No Data Available') }}</h3>
                <p class="text-gray-500">{{ __('Statistics will appear here once available') }}</p>
            </div>
        @endif
    </div>
</section>

<script>
    function animateCounter(element, target, duration) {
        let start = 0;
        const increment = target / (duration / 16);
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target.toLocaleString(); // Add number formatting
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start).toLocaleString();
            }
        }, 16);
    }

    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    animateCounter(counter, target, 2000);
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const section = document.getElementById('funFactsSection');
    if (section) {
        observer.observe(section);
    }
</script>