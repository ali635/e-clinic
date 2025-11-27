{{-- YouTube Video Section --}}
@if (setting_lang('home_video'))
    <section class="py-16 bg-gradient-to-br from-blue-50 to-white">
        <div class="container">
            <div class="max-w-5xl mx-auto">
                {{-- Header --}}
                <div class="text-center mb-10">
                    <h2 class="text-3xl tablet:text-4xl font-bold text-gray-900 mb-3">
                        {{ __('Watch Our Introduction') }}
                    </h2>
                    <p class="text-lg text-gray-600">
                        {{ __('Learn more about our services and commitment to your health') }}
                    </p>
                </div>

                {{-- Video Container --}}
                <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-900">
                    {{-- 16:9 Aspect Ratio Container --}}
                    <div class="relative pb-[56.25%] h-0">
                        <iframe class="absolute top-0 left-0 w-full h-full"
                            src="https://www.youtube.com/embed/{{ setting_lang('home_video') }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                {{-- Optional: Video Description --}}
                {{-- <div class="text-center mt-8">
                <p class="text-gray-600 max-w-2xl mx-auto">
                    {{ __('Discover how our team of experts provides world-class medical care with state-of-the-art facilities and compassionate service.') }}
                </p>
            </div> --}}
            </div>
        </div>
    </section>
@endif
