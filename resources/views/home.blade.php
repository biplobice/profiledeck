@extends('layouts.site')

@section('title', $data->profile->name.' — '.$data->profile->headline)
@section('description', $data->resolve($data->profile->summary))

@section('header')
    @php
        $siteHost = parse_url($data->profile->website, PHP_URL_HOST) ?: config('app.name');
        $blogName = parse_url($data->profile->blog_url, PHP_URL_HOST) ?: 'Writing';
        $nameParts = preg_split('/\s+/', trim($data->profile->name), 2);
        $watermark = collect(explode(' ', $data->profile->name))->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
        $hostMatch = [];
        preg_match('/^([^.]+)(\..+)$/', $siteHost, $hostMatch);
    @endphp

    <header class="site-header">
        <div class="site-shell header-inner">
            <a href="{{ url('/') }}" class="site-brand" rel="home">
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
                <a href="#experience">Experience</a>
                <a href="#work">Work</a>
                <a href="#skills">Skills</a>
                <a href="#about">About</a>
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
@endsection

@section('content')
    <section class="site-shell hero">
        <div>
            <p class="eyebrow">{{ $data->profile->headline }} · {{ $data->profile->location }}</p>
            <h1>
                @if (isset($nameParts[1]))
                    {{ $nameParts[0] }} <span>{{ $nameParts[1] }}</span>
                @else
                    <span>{{ $data->profile->name }}</span>
                @endif
            </h1>
            <p class="hero-intro">{{ $data->resolve($data->profile->tagline) }}</p>
            <div class="hero-actions">
                <a href="{{ route('cv.pdf') }}" class="btn btn-primary">Download CV &nbsp;→</a>
                <button type="button" data-email="{{ base64_encode($data->profile->email) }}" class="btn btn-ghost">Email me</button>
            </div>
        </div>

        <div class="hero-card" aria-label="A short introduction">
            <div class="terminal-bar" aria-hidden="true"><i></i><i></i><i></i></div>
            <code>
                <span class="code-muted">$</span> whoami<br>
                {{ $data->profile->name }}<br><br>
                <span class="code-muted">$</span> focus --today<br>
                <span class="code-accent">useful products</span><br>
                clean architecture<br>
                curious experiments<br><br>
                <span class="code-muted">$</span> status<br>
                @if ($data->currentRole)
                    {{ strtolower($data->currentRole->title) }} @ {{ strtolower($data->currentRole->company->name) }}<span class="blink"></span>
                @else
                    quietly building<span class="blink"></span>
                @endif
            </code>
        </div>
    </section>

    <div class="site-shell stat-grid">
        <article class="stat-card">
            <p class="stat-value">{{ $data->yearsOfExperience() }}+</p>
            <p class="stat-label">years building software</p>
        </article>
        <article class="stat-card">
            <p class="stat-value">{{ $data->experiences->count() }}</p>
            <p class="stat-label">roles across the career timeline</p>
        </article>
        <article class="stat-card">
            <p class="stat-value">{{ $data->featuredProjects->count() }}</p>
            <p class="stat-label">selected projects on this page</p>
        </article>
        <article class="stat-card">
            <p class="stat-value">{{ $data->profile->blog_url ? 2 : 1 }}</p>
            <p class="stat-label">public destinations for work and writing</p>
        </article>
    </div>

    <section id="about" class="site-shell section">
        <div class="about-strip" data-watermark="{{ $watermark }}">
            <div>
                <p class="eyebrow">01 — About</p>
                <h2>Build calmly. Ship thoughtfully.</h2>
            </div>
            <div class="about-copy">
                <p>{{ $data->resolve($data->profile->bio) }}</p>
                <a href="#experience" class="btn btn-accent">See the work history &nbsp;↗</a>
            </div>
        </div>
    </section>

    <section id="experience" class="section border-y border-[color:var(--color-line)] bg-[color-mix(in_srgb,var(--color-mist)_55%,transparent)]">
        <div class="site-shell">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">02 — Experience</p>
                    <h2>Work history</h2>
                </div>
            </div>

            <ol class="timeline space-y-10">
                @foreach ($data->experiences as $experience)
                    <li class="relative grid gap-2 pl-7 md:grid-cols-[8.5rem_1fr] md:gap-12 md:pl-0">
                        <span class="timeline-dot"></span>
                        <p class="pt-0.5 font-mono text-sm text-[color:var(--color-muted)]">{{ $experience->periodLabel() }}</p>
                        <div>
                            <h3 class="text-xl font-semibold tracking-tight">{{ $experience->title }}</h3>
                            <p class="mt-1 text-[color:var(--color-clay)]">
                                @if ($experience->company->website)
                                    <a href="{{ $experience->company->website }}" target="_blank" rel="noreferrer">{{ $experience->company->name }}</a>
                                @else
                                    {{ $experience->company->name }}
                                @endif
                                @if ($experience->company->former_name)
                                    <span class="text-[color:var(--color-muted)]">· formerly {{ $experience->company->former_name }}</span>
                                @endif
                            </p>
                            @if ($experience->summary)
                                <p class="mt-3 text-[color:var(--color-muted)]">{{ $experience->summary }}</p>
                            @endif
                            @if ($experience->responsibilities)
                                <ul class="mt-4 space-y-1.5 text-[color:var(--color-muted)]">
                                    @foreach ($experience->responsibilities as $item)
                                        <li class="flex gap-3">
                                            <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-[color:var(--color-clay)]"></span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section id="work" class="site-shell section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">03 — Selected work</p>
                <h2>Projects worth opening</h2>
            </div>
        </div>

        <div class="project-grid">
            @foreach ($data->featuredProjects as $project)
                <article class="project-card">
                    <div class="project-card-media">
                        @if ($project->thumbnailUrl())
                            <img src="{{ $project->thumbnailUrl() }}" alt="{{ $project->name }}" loading="lazy">
                        @else
                            <div class="project-monogram">{{ $project->initials() }}</div>
                        @endif
                        <span class="project-kind">{{ $project->kind }}</span>
                    </div>
                    <div class="project-card-body">
                        <h3>
                            @if ($project->url)
                                <a href="{{ $project->url }}" target="_blank" rel="noreferrer">{{ $project->name }}</a>
                            @else
                                {{ $project->name }}
                            @endif
                        </h3>
                        @if ($project->company)
                            <p class="font-mono text-xs uppercase tracking-[0.08em] text-[color:var(--color-muted)]">{{ $project->company->name }}</p>
                        @endif
                        @if ($project->summary)
                            <p>{{ $project->summary }}</p>
                        @endif
                        @if ($project->technologies)
                            <div class="chip-row">
                                @foreach ($project->technologies as $technology)
                                    <span class="chip">{{ $technology }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section id="skills" class="section border-y border-[color:var(--color-line)] bg-[color-mix(in_srgb,var(--color-mist)_55%,transparent)]">
        <div class="site-shell">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">04 — Skills</p>
                    <h2>Tools I reach for</h2>
                </div>
                <p class="max-w-xs text-sm leading-6 text-[color:var(--color-muted)]">Grouped by how I actually use them — languages, stack, and the services around the work.</p>
            </div>

            <div class="skill-grid">
                @foreach ($data->skillCategories as $category)
                    <article class="skill-card">
                        <header class="skill-card-header">
                            <span class="skill-index" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <h3>{{ $category->name }}</h3>
                                <p class="skill-count">{{ $category->skills->count() }} {{ $category->skills->count() === 1 ? 'skill' : 'skills' }}</p>
                            </div>
                        </header>
                        <div class="chip-row">
                            @foreach ($category->skills as $skill)
                                <span class="chip">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($data->profile->blog_url)
        <section id="writing" class="site-shell section">
            <div class="grid items-end gap-8 md:grid-cols-[1.2fr_0.8fr]">
                <div>
                    <p class="eyebrow">05 — Writing</p>
                    <h2 class="max-w-2xl text-[clamp(2rem,5vw,3.2rem)] leading-[0.98] tracking-[-0.06em]">Longer notes live on {{ $blogName }}</h2>
                    <p class="mt-4 max-w-xl text-[color:var(--color-muted)] text-lg leading-8">This profile is for career highlights and selected work. The writing site keeps longer notes in their own focused home.</p>
                </div>
                <a href="{{ $data->profile->blog_url }}" class="writing-card" target="_blank" rel="noreferrer">
                    <span>
                        <span class="writing-card-label">Read</span>
                        <span class="writing-card-title">{{ $blogName }}</span>
                    </span>
                    <span aria-hidden="true" class="text-2xl">→</span>
                </a>
            </div>
        </section>
    @endif

    <section id="background" class="site-shell section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">06 — Background</p>
                <h2>School, certifications, and the rest</h2>
            </div>
        </div>

        <div class="panel-grid">
            @if ($data->educations->isNotEmpty())
                <div class="panel">
                    <h3 class="panel-title">Education</h3>
                    <ul class="panel-list">
                        @foreach ($data->educations as $education)
                            <li>
                                <p class="font-medium">{{ $education->credential }}</p>
                                <p class="text-[color:var(--color-muted)]">{{ $education->institution }}</p>
                                <p class="mt-1 font-mono text-sm text-[color:var(--color-muted)]">{{ $education->started_on?->format('Y') }}–{{ $education->ended_on?->format('Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($data->certifications->isNotEmpty())
                <div class="panel">
                    <h3 class="panel-title">Certifications</h3>
                    <ul class="panel-list">
                        @foreach ($data->certifications as $certification)
                            <li class="flex items-baseline justify-between gap-4">
                                <span>
                                    <span class="block font-medium">{{ $certification->name }}</span>
                                    <span class="block text-[color:var(--color-muted)]">{{ $certification->organization }}{{ $certification->result ? ' · '.$certification->result : '' }}</span>
                                </span>
                                <span class="shrink-0 font-mono text-sm text-[color:var(--color-muted)]">{{ $certification->awarded_on?->format('Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($data->trainings->isNotEmpty())
                <div class="panel">
                    <h3 class="panel-title">Training</h3>
                    <ul class="panel-list">
                        @foreach ($data->trainings as $training)
                            <li>
                                <p class="font-medium">{{ $training->name }}</p>
                                @if ($training->organization)
                                    <p class="text-[color:var(--color-muted)]">{{ $training->organization }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($data->interests->isNotEmpty())
                <div class="panel">
                    <h3 class="panel-title">Interests</h3>
                    <div class="chip-row">
                        @foreach ($data->interests as $interest)
                            <span class="chip">{{ $interest->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('footer')
    <footer id="contact" class="site-footer">
        <div class="site-shell footer-main">
            <h2 class="footer-title">Let’s build something <span>thoughtful.</span></h2>
            <div class="footer-side">
                <p>{{ $data->profile->name }} · {{ $data->profile->location }}</p>
                <button type="button" data-email="{{ base64_encode($data->profile->email) }}" class="btn btn-ghost border-[color:var(--color-inverse-line)] text-[color:var(--color-inverse-fg)] hover:border-[color:var(--color-clay)] hover:text-[color:var(--color-clay)]">
                    Email me &nbsp;→
                </button>
                <p class="text-sm text-[color:var(--color-inverse-soft)]">The address opens in your mail app — it is kept out of the page to deter scrapers.</p>
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
@endsection
