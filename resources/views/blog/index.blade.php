@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', __('Our Blog - Latest News and Updates'))
@section('description', __('Explore the latest articles, updates, and insights from our team.'))
@section('keywords', __('blog, news, updates, health tips, clinics, 3M Services'))
@section('og_title', __('Our Blog - Latest News and Updates'))
@section('og_description', __('Explore the latest articles, updates, and insights from our team.'))
@section('og_type', 'website')
@section('twitter_title', __('Our Blog - Latest News and Updates'))
@section('twitter_description', __('Explore the latest articles, updates, and insights from our team.'))

@section('content')
    <section class="py-16 bg-gradient-to-br from-gray-50 to-white relative">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 relative inline-block">
                    {{ __('Blogs') }}
                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-primary to-primary/60 rounded-full"></span>
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('Explore the latest articles, updates, and insights from our team') }}
                </p>
            </div>

            <!-- Blog Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse ($posts as $post)
                    @if ($post->slug)
                        <article class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 relative border border-gray-100 reveal-up">
                            
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
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/read:translate-x-1 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endif
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-200">
                            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14-7l-2 2m0 0l-2-2m2 2V3m2 4H5m14 10l-2-2m0 0l-2 2m2-2v2M9 3v2m3 0v2m3 0v2"/>
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700 mb-3">{{ __('No Articles Found') }}</h3>
                            <p class="text-gray-500 text-lg max-w-md mx-auto">{{ __('Stay tuned! New articles will be published soon.') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($posts->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-md p-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection