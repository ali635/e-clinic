<section class="py-12">
    <div class="container">
        <h2 class="text-3xl tablet:text-4xl font-bold text-center text-primary mb-4">
            {{ __('Our Results Numbers') }}
        </h2>
        <p class="text-center text-gray-600 mb-12 text-lg">
           {{ __('Numbers that speak for themselves') }}
        </p>

        @if (setting('counter_settings'))

            <div id="funFactsSection" class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-6 tablet:gap-8">
                <!-- Fact 1 -->
                @foreach (setting('counter_settings') as $counter)
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                        <div class="flex items-center justify-center gap-2 mb-4">
                            <span class="text-5xl tablet:text-6xl font-bold text-primary counter"
                                data-target="{{ $counter['number_vendor'] }}">
                                {{ $counter['number_vendor'] }}
                            </span>
                            <span class="text-4xl tablet:text-5xl font-bold text-primary">
                                +
                            </span>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">
                            {{ $counter['vendor'] }}
                        </p>
                    </div>
                @endforeach
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
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start);
            }
        }, 16);
    }

    const observerOptions = {
        threshold: 0.5,
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
    observer.observe(section);
</script>
