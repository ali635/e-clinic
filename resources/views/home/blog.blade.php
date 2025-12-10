<section class="py-12">
    <div class="container">
        <div class="flex flex-col tablet:flex-row tablet:justify-between tablet:items-center gap-2 mb-8">
            <h2 class="text-3xl tablet:text-4xl font-bold text-primary">
                {{ __('Blogs') }}
            </h2>
            <a href="{{ route('posts') }}"
                class="text-primary self-end tablet:self-center border border-primary text-center px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition duration-300 ease-in-out">{{ __('All Blogs') }}</a>
        </div>
        <div class="grid grid-cols-1 tablet:grid-cols-2 web:grid-cols-4 gap-4">
            @foreach ($posts as $post)
                <article class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100">
                            
                            <!-- Image Section -->
                            <div class="relative h-56 md:h-64 overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                                
                                <!-- Overlay on hover -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Date Badge -->
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm">
                                    <time class="text-sm font-semibold text-gray-900">
                                        {{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->format('M d, Y') : '' }}
                                    </time>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6 md:p-7">
                                <h3 class="text-xl md:text-2xl font-bold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                                    {{ $post->name }}
                                </h3>
                                
                                <p class="text-sm md:text-base text-gray-600 mb-5 line-clamp-3 leading-relaxed">
                                    {!! Str::limit(strip_tags($post->short_description ?? ''), 120) !!}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4-4-4z"/>
                                        </svg>
                                        {{ __('Read more') }}
                                    </div>
                                    
                                    <a href="{{ route('post.show', $post->slug) }}"
                                       class="inline-flex items-center gap-2 text-primary font-semibold hover:text-primary/80 transition-all duration-300 group/read">
                                        <span class="group-hover/read:translate-x-1 transition-transform duration-300">{{ __('View Article') }}</span>
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/read:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
            @endforeach

        </div>
    </div>
</section>
