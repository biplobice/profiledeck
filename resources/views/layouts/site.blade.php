<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10140f">
    <title>@yield('title', config('app.name'))</title>
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @endif
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-mark.svg') }}">
    @include('partials.theme-init')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=IBM+Plex+Mono:wght@500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body @class(trim($__env->yieldContent('body_class')))>
    <div class="reading-progress" data-reading-progress aria-hidden="true"></div>
    <a class="skip-link" href="#main">Skip to content</a>

    @yield('header')

    <main id="main">
        @yield('content')
    </main>

    @yield('footer')
</body>
</html>
