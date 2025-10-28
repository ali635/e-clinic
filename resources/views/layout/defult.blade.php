<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getDirection() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', __('Home'))</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('storage/' . setting('site_logo')) }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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


<body class="{{ $currentFont }}" dir="{{ getDirection() }}">
    @include('share.header')
    @yield('content')
    @include('share.footer')

        {!! ToastMagic::scripts() !!}

</body>

</html>
