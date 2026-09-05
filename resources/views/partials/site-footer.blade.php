@php
    $siteHost = parse_url($data->profile->website, PHP_URL_HOST) ?: config('app.name');
@endphp

<footer id="contact" class="site-footer">
    <div class="site-shell footer-main">
        <h2 class="footer-title">Let’s build something <span>thoughtful.</span></h2>
        <div class="footer-side">
            <p>{{ $data->profile->name }} · {{ $data->profile->location }}</p>
            <button type="button" data-email="{{ base64_encode($data->profile->email) }}" class="btn btn-ghost">
                Email me &nbsp;→
            </button>
            <div class="footer-links">
                @if ($data->profile->blog_url)
                    <a href="{{ $data->profile->blog_url }}" target="_blank" rel="noreferrer">Blog</a>
                @endif
                @if ($data->profile->github_url)
                    <a href="{{ $data->profile->github_url }}" target="_blank" rel="noreferrer">GitHub</a>
                @endif
                @if ($data->profile->linkedin_url)
                    <a href="{{ $data->profile->linkedin_url }}" target="_blank" rel="noreferrer">LinkedIn</a>
                @endif
                <a href="{{ route('cv.pdf') }}">CV PDF</a>
            </div>
        </div>
    </div>
    <div class="site-shell footer-bottom">
        <span>&copy; {{ now()->year }} {{ $siteHost }}</span>
        <span>Designed &amp; built with care in code.</span>
    </div>
</footer>
