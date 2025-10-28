@extends('layout.defult')

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
    <section class="service-hero relative h-[70vh] min-h-[500px] overflow-hidden">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>

        <!-- Hero Content -->
        <div class="absolute inset-0 flex items-center justify-center z-[2]">
            <div class="container text-center">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl tablet:text-5xl web:text-6xl font-bold text-white mb-6 leading-tight capitalize">
                        {{ $post->name }}
                    </h1>

                    <!-- Blog Meta Information -->
                    <div class="flex flex-col tablet:flex-row items-center justify-center gap-4 tablet:gap-8 text-white/90">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-lg font-medium">
                                {{ __('Published') }}: {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg font-medium">
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
    <section class="py-16 bg-white animate-slide-up">
        <div class="container">
            <div class="grid grid-cols-1 web:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="web:col-span-3 order-2 web:order-1">
                    <div class="text-gray-700 leading-relaxed text-lg">
                        {!! $post->description !!}
                    </div>
                </div>

                <!-- Blog Meta Sidebar -->
                <div class="space-y-6 order-1 web:order-2">
                    <!-- Article Info Card -->
                    <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 border border-primary/20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 me-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Article Information') }}
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-start justify-between py-3 border-b border-primary/20">
                                <span class="text-gray-600 font-medium">{{ __('Published Date') }}</span>
                                <div class="text-end">
                                    <span
                                        class="text-gray-900 font-semibold">{{ $post->created_at->format('M d, Y') }}</span>
                                    <div class="text-sm text-gray-500">{{ $post->created_at->format('h:i A') }}</div>
                                </div>
                            </div>

                            @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                                <div class="flex items-start justify-between py-3 border-b border-primary/20">
                                    <span class="text-gray-600 font-medium">{{ __('Last Updated') }}</span>
                                    <div class="text-end">
                                        <span
                                            class="text-gray-900 font-semibold">{{ $post->updated_at->format('M d, Y') }}</span>
                                        <div class="text-sm text-gray-500">{{ $post->updated_at->format('h:i A') }}</div>
                                    </div>
                                </div>
                            @endif

                            <!-- <div class="flex items-center justify-between py-3 border-b border-primary/20">
                                <span class="text-gray-600 font-medium">{{ __('Reading Time') }}</span>
                                <span class="text-gray-900 font-semibold">
                                    @php
                                        $wordCount = str_word_count(strip_tags($post->description));
                                        $readingTime = max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
                                    @endphp
                                    {{ $readingTime }} {{ __('min read') }}
                                </span>
                            </div> -->
                        </div>
                    </div>

                    <!-- Share Article Card -->
                    <!-- <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 me-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                            </svg>
                            {{ __('Share Article') }}
                        </h3>
                        <p class="text-gray-600 mb-4">{{ __('Share this article with others') }}</p>
                        <div class="flex gap-3">
                            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <svg class="w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M20 10C20 4.477 15.523 0 10 0S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path>
                                </svg>
                                Facebook
                            </button>
                            <button class="flex-1 bg-blue-400 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                <svg class="w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                                Twitter
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
@endsection
