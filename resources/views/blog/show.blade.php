@extends('layout.defult')

{{-- 🧠 SEO & Social Meta --}}
@section('title', $post->name)
@section('description', __('Read detailed insights and updates in our blog post titled ":title".', ['title' =>
    $post->name]))
@section('keywords', __('blog, article, health, clinics, medical, 3M Services, :title', ['title' => $post->name]))
@section('og_title', $post->name)
@section('og_description', __('Explore more about ":title" and other helpful articles from our team.', ['title' =>
    $post->name]))
@section('og_type', 'article')
@section('twitter_title', $post->name)
@section('twitter_description', __('Explore the latest articles, updates, and insights from our team.'))

@section('content')

    <!-- Hero Section with Blog Image Banner -->
    <section class="relative h-[70vh] min-h-[500px] overflow-hidden">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>

        <!-- Hero Content -->
        <div class="absolute inset-0 flex items-center justify-center z-[2]">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight capitalize drop-shadow-lg">
                        {{ $post->name }}
                    </h1>

                    <!-- Blog Meta Information -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 text-white/90 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full w-max mx-auto">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-base font-medium">
                                {{ __('Published') }}: {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="text-base font-medium">
                                    {{ __('Updated') }}: {{ $post->updated_at->format('M d, Y') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                        {!! $post->description !!}
                    </div>
                </div>

                <!-- Blog Meta Sidebar -->
                <div class="space-y-6">
                    <!-- Article Info Card -->
                    <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 border border-primary/20 shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2 pb-4 border-b border-primary/20">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Article Information') }}
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-start justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">{{ __('Published Date') }}</span>
                                <div class="text-right">
                                    <div class="text-gray-900 font-semibold">{{ $post->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $post->created_at->format('h:i A') }}</div>
                                </div>
                            </div>

                            @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                                <div class="flex items-start justify-between py-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">{{ __('Last Updated') }}</span>
                                    <div class="text-right">
                                        <div class="text-gray-900 font-semibold">{{ $post->updated_at->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $post->updated_at->format('h:i A') }}</div>
                                    </div>
                                </div>
                            @endif

                            <!-- <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">{{ __('Reading Time') }}</span>
                                <span class="text-gray-900 font-semibold">
                                    @php
                                        $wordCount = str_word_count(strip_tags($post->description));
                                        $readingTime = max(1, ceil($wordCount / 200));
                                    @endphp
                                    {{ $readingTime }} {{ __('min read') }}
                                </span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection