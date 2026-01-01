<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') {{ config('app.name', 'Laravel') }}</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162043267-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-162043267-2');
    </script>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('css/app_0.css') }}" rel="stylesheet">
    {{-- <link href="" rel="stylesheet"> --}}
    <!-- Preload images -->
    <link rel="preload" href="{{ asset('images/d2.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d4.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d6.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d8.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d10.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d12.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d20.svg') }}" as="image">
    <link rel="preload" href="{{ asset('images/d100.svg') }}" as="image">
</head>
<body>
    <div>
        <nav class="navbar">

            <div class="navbar-brand navbar-start">
                <a class="navbar-item" href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}">
                    <img src="{{ asset('images/dicechat_logo.svg') }}" alt="{{ config('app.name', 'Laravel') }}" height="40">
                </a>
            </div>

            <div class="navbar-item navbar-end">
                <select name="theme" id="theme_selector">
                    <option value="0">Default</option>
                    <option value="1">One Ring - Light</option>
                    <option value="2">One Ring - Dark</option>
                </select>
            </div>
        </nav>

        <main class="container-fluid">
            @yield('content')
        </main>
    </div>
</body>
</html>
