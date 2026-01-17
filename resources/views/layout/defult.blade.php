<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getDirection() }}">
@php
    $isProductionMode = config('app.env') == 'production';
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', __('Home'))</title>
    <link rel="shortcut icon" href="{{ asset(setting('site_logo')) }}" type="image/x-icon">

    {{-- Basic Meta Tags --}}
    <meta name="description" content="@yield('meta_description', __('E-Clinic - Your trusted healthcare partner'))">
    <meta name="keywords" content="@yield('meta_keywords', __('healthcare, clinic, medical, doctor, appointment'))">
    <meta name="author" content="@yield('meta_author', __('E-Clinic'))">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="revisit-after" content="7 days">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="theme-color" content="@yield('theme_color', '#03bafc')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    {{-- Alternate Language Versions --}}

    {{-- Open Graph Meta Tags --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', $title ?? __('Dr Azad Hasan'))">

    <meta property="og:description" content="@yield('og_description', __('E-Clinic - Your trusted healthcare partner'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="@yield('og_site_name', __('Dr Azad Hasan'))">
    <meta property="og:image" content="@yield('og_image', asset(setting('site_logo')))">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="@yield('og_image_alt', __('Dr Azad Hasan'))">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta property="og:updated_time" content="@yield('og_updated_time', now()->toISOString())">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:site" content="@yield('twitter_site', __('Dr Azad Hasan'))">
    <meta name="twitter:creator" content="@yield('twitter_creator', __('Dr Azad Hasan'))">
    <meta name="twitter:title" content="@yield('twitter_title', __('Dr Azad Hasan'))">
    <meta name="twitter:description" content="@yield('twitter_description', __('E-Clinic - Your trusted healthcare partner'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset(setting('site_logo')))">
    <meta name="twitter:image:alt" content="@yield('twitter_image_alt', __('Dr Azad Hasan'))">
    <meta name="twitter:domain" content="@yield('twitter_domain', request()->getHost())">

    {{-- Mobile App Meta Tags --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="@yield('app_title', __('Dr Azad Hasan'))">
    <meta name="application-name" content="@yield('app_name', __('Dr Azad Hasan'))">
    <meta name="msapplication-TileColor" content="@yield('ms_tile_color', '#03bafc')">
    <meta name="msapplication-config" content="@yield('ms_config', '/browserconfig.xml')">

    {{-- Page-specific SEO --}}
    @yield('page_seo')


    @if ($isProductionMode)
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Kurdish Font Support --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {!! ToastMagic::styles() !!}
    @php
        $languagesFonts = [
            'ar' => 'Cairo',
            'ku' => 'Noto Sans Arabic',
            'en' => 'Inter',
        ];

        $currentFont = $languagesFonts[str_replace('_', '-', app()->getLocale())];
        $isKurdish = str_replace('_', '-', app()->getLocale()) === 'ku';
    @endphp
    <style>
        @if (!$isKurdish)
            @font-face {
                font-family: {{ $currentFont }};
                src: url("{{ asset('fonts/' . $currentFont . '-Regular.ttf') }}") format("truetype");
                font-weight: 400;
                font-display: swap;
            }

            @font-face {
                font-family: {{ $currentFont }};
                src: url("{{ asset('fonts/' . $currentFont . '-Medium.ttf') }}") format("truetype");
                font-weight: 500;
                font-display: swap;
            }

            @font-face {
                font-family: {{ $currentFont }};
                src: url("{{ asset('fonts/' . $currentFont . '-SemiBold.ttf') }}") format("truetype");
                font-weight: 600;
                font-display: swap;
            }

            @font-face {
                font-family: {{ $currentFont }};
                src: url("{{ asset('fonts/' . $currentFont . '-Bold.ttf') }}") format("truetype");
                font-weight: 700;
                font-display: swap;
            }
        @endif

        /* Kurdish language specific styles */
        @if ($isKurdish)
            body {
                font-family: 'Noto Sans Arabic', 'Cairo', sans-serif !important;
            }
        @endif
    </style>

</head>


<body dir="{{ getDirection() }}">
    <div id="loader-overlay"
        class="fixed inset-0 flex items-center justify-center bg-white transition-opacity duration-700 z-[99]">
        <div class="flex flex-col items-center">
            <img src="{{ asset(setting('site_logo')) }}" alt="{{ setting('site_name') }}"
                class="md:w-[200px] md:h-[200px] w-[100px] h-[100px] animate-bounce" />
        </div>
    </div>

    @include('share.header')
    @yield('content')
    @include('share.footer')

    @if ($isProductionMode)
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @endif
    {!! ToastMagic::scripts() !!}

    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader-overlay');
            if (loader) {
                document.body.classList.add('pageLoaded');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 800);
            }
        });
    </script>
</body>

</html>
