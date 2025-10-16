<section class="hero_banners">
    <div class="embla">
        <div class="embla__viewport">
            <div class="embla__container">
                @foreach ($banners as $banner)
                    <div class="embla__slide">
                        <img class="max-h-[600px] h-[80vh] w-full object-cover" src="{{ asset('storage/' . $banner->image) }}"
                            alt="{{ $banner->name }}">
                        
                        <div class="slide_content">
                            <h2 class="slideTitle text-xl tablet:text-2xl font-bold mb-2 tablet:mb-3 text-gray-800">
                                {{ $banner->name }}
                            </h2>
                            <div class="slideDescription text-sm tablet:text-base text-gray-600 mb-5">{!!  $banner->description !!}</div>
        
                            <a class="p-2 text-white rounded bg-primary transition-colors hover:opacity-80" href="{{ $banner->link }}">{{__('Explore')}}</a>
                        </div>    
    
                    </div>
                @endforeach
            </div>
        </div>
        <div class="embla__controls">
            <div class="embla__dots"></div>
        </div>
    </div>
</section>

