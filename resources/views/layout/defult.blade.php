<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getDirection() }}">
@php
    $isProductionMode = config(key: 'app.env') == 'production';
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', __('Home'))</title>
    <link rel="shortcut icon" href="{{ asset('storage/' . setting('site_logo')) }}" type="image/x-icon">


    @if($isProductionMode)
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    {!! ToastMagic::styles() !!}
    @php
        $languagesFonts = [
            'ar' => 'Cairo',
            'ku' => 'Cairo',
            'en' => 'Inter',
        ];

        $currentFont = $languagesFonts[str_replace('_', '-', app()->getLocale())];
    @endphp
    <style>
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
    </style>

</head>


<body dir="{{ getDirection() }}">
    @include('share.header')
    @yield('content')
    @include('share.footer')

    @if($isProductionMode)
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @endif
    {!! ToastMagic::scripts() !!}
</body>

</html>
