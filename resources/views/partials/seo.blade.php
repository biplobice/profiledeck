@php
    $seoProfile = $seoProfile ?? (isset($data) ? $data->profile : \App\Models\Profile::query()->first());
    $seoTitle = trim($__env->yieldContent('title', $seoProfile->name ?? config('app.name')));
    $seoDescription = trim($__env->yieldContent('description', $seoProfile->headline ?? ''));
    $seoUrl = url()->current();
    $seoImage = $seoProfile?->photoUrl();
@endphp

<link rel="canonical" href="{{ $seoUrl }}">
@if (filled(config('tracking.google_site_verification')))
    <meta name="google-site-verification" content="{{ config('tracking.google_site_verification') }}">
@endif
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $seoProfile->name ?? config('app.name') }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:url" content="{{ $seoUrl }}">
@if ($seoDescription !== '')
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
@endif
@if ($seoImage)
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
@endif
<meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">

@if ($seoProfile)
    @php
        $personSchema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $seoProfile->name,
            'jobTitle' => $seoProfile->headline,
            'description' => $seoDescription !== '' ? $seoDescription : null,
            'url' => $seoProfile->website ?: url('/'),
            'image' => $seoImage,
            'address' => filled($seoProfile->location) ? [
                '@type' => 'PostalAddress',
                'addressLocality' => $seoProfile->location,
            ] : null,
            'sameAs' => array_values(array_filter([
                $seoProfile->website,
                $seoProfile->blog_url,
                $seoProfile->github_url,
                $seoProfile->linkedin_url,
                $seoProfile->twitter_url,
            ])),
        ]);
    @endphp
    <script type="application/ld+json">
        {!! json_encode($personSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
@endif
