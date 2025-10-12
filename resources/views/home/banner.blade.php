<section class="hero_banners">
    <div class="embla">
        <div class="embla__container">
            @foreach ($banners as $banner)
                <div class="embla__slide">
                    <img class="max-h-[600px] h-[80vh] w-full object-cover" src="{{ asset('storage/' . $banner->image) }}"
                        alt="{{ $banner->name }}">
                    <h2 class="text-xl tablet:text-2xl font-bold mb-2 tablet:mb-3 text-gray-800">{{ $banner->name }}
                    </h2>
                    <p class="text-sm tablet:text-base text-gray-600 mb-5">{{ $banner->description }}</p>

                    <a href="{{ $banner->link }}">btton link</a>

                </div>
            @endforeach

        </div>
    </div>
</section>
