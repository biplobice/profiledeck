@extends('layouts.site')

@section('title', 'CV — '.$data->profile->name)

@section('content')
    <div class="site-shell cv-page">
        <div class="cv-toolbar">
            <p>Printable HTML preview for {{ $data->profile->name }}.</p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-ghost">Back to profile</a>
                <button type="button" class="icon-button theme-toggle" data-theme-toggle aria-label="Change color theme">
                    <svg class="sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"></path>
                    </svg>
                    <svg class="moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"></path>
                    </svg>
                </button>
                <a href="{{ route('cv.pdf') }}" class="btn btn-primary">Download PDF &nbsp;→</a>
            </div>
        </div>

        <div class="cv-document">
            @include('partials.cv-content', ['data' => $data])
        </div>
    </div>
@endsection
