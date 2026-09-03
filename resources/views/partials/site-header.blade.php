@php
    $siteHost = parse_url($data->profile->website, PHP_URL_HOST) ?: config('app.name');
    $hostMatch = [];
    preg_match('/^([^.]+)(\..+)$/', $siteHost, $hostMatch);
    $section = fn (string $id) => request()->routeIs('home') ? '#'.$id : route('home').'#'.$id;
@endphp

<header class="site-header">
    <div class="site-shell header-inner">
        <a href="{{ route('home') }}" class="site-brand" rel="home">
            <img class="brand-mark" src="{{ asset('images/logo-mark.svg') }}" alt="" width="38" height="38">
            <span class="brand-domain">
                @if ($hostMatch)
                    {{ $hostMatch[1] }}<span class="brand-dot">{{ $hostMatch[2] }}</span>
                @else
                    {{ $siteHost }}
                @endif
            </span>
        </a>

        <nav class="site-nav" aria-label="Primary navigation" data-menu>
            <a href="{{ $section('experience') }}">Experience</a>
            <a href="{{ $section('work') }}">Work</a>
            <a href="{{ $section('skills') }}">Skills</a>
            <a href="{{ $section('about') }}">About</a>
            @if ($data->profile->blog_url)
                <a href="{{ $data->profile->blog_url }}" target="_blank" rel="noreferrer">Writing</a>
            @endif
        </nav>

        <div class="header-actions">
            <button type="button" class="icon-button theme-toggle" data-theme-toggle aria-label="Change color theme">
                <svg class="sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"></path>
                </svg>
                <svg class="moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"></path>
                </svg>
            </button>
            <a href="{{ route('cv.pdf') }}" class="btn btn-primary">Download CV</a>
            <button type="button" class="icon-button menu-toggle" data-menu-toggle aria-label="Open menu" aria-expanded="false">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
            </button>
        </div>
    </div>
</header>
