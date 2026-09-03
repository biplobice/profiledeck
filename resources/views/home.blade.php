<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data->profile->name }} — {{ $data->profile->headline }}</title>
    <meta name="description" content="{{ $data->resolve($data->profile->summary) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $siteName = parse_url($data->profile->website, PHP_URL_HOST) ?: config('app.name');
        $blogName = parse_url($data->profile->blog_url, PHP_URL_HOST) ?: 'Writing';
    @endphp
    <header class="sticky top-0 z-20 border-b border-line/80 bg-paper/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4 md:px-8">
            <a href="{{ url('/') }}" class="font-display text-xl font-semibold tracking-tight">{{ $siteName }}</a>
            <nav class="hidden items-center gap-7 text-sm font-medium text-ink/70 md:flex">
                <a href="#experience" class="hover:text-ink">Experience</a>
                <a href="#work" class="hover:text-ink">Work</a>
                <a href="#about" class="hover:text-ink">About</a>
                @if ($data->profile->blog_url)
                    <a href="{{ $data->profile->blog_url }}" class="hover:text-ink" target="_blank" rel="noreferrer">Writing</a>
                @endif
                <a href="{{ route('cv.pdf') }}" class="rounded-full bg-ink px-4 py-2 text-paper hover:bg-clay">Download CV</a>
            </nav>
            <details class="site-nav relative md:hidden">
                <summary class="cursor-pointer rounded-full border border-line px-3 py-1.5 text-sm">Menu</summary>
                <div class="absolute right-0 mt-2 w-48 rounded-2xl border border-line bg-paper p-3 shadow-sm">
                    <a class="block rounded-lg px-3 py-2 text-sm hover:bg-mist" href="#experience">Experience</a>
                    <a class="block rounded-lg px-3 py-2 text-sm hover:bg-mist" href="#work">Work</a>
                    <a class="block rounded-lg px-3 py-2 text-sm hover:bg-mist" href="#about">About</a>
                    @if ($data->profile->blog_url)
                        <a class="block rounded-lg px-3 py-2 text-sm hover:bg-mist" href="{{ $data->profile->blog_url }}" target="_blank" rel="noreferrer">Writing</a>
                    @endif
                    <a class="mt-1 block rounded-lg bg-ink px-3 py-2 text-sm text-paper" href="{{ route('cv.pdf') }}">Download CV</a>
                </div>
            </details>
        </div>
    </header>

    <main>
        <section class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-14 md:grid-cols-[1.15fr_0.85fr] md:px-8 md:py-20">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.22em] text-clay">{{ $data->profile->headline }} · {{ $data->profile->location }}</p>
                <h1 class="font-display mt-4 text-5xl font-medium leading-[0.95] tracking-tight md:text-7xl">{{ $data->profile->name }}</h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-ink/75">{{ $data->resolve($data->profile->tagline) }}</p>
                @if ($data->currentRole)
                    <p class="mt-5 text-ink/70">
                        Currently {{ $data->currentRole->title }} at
                        <span class="font-medium text-ink">{{ $data->currentRole->company->name }}</span>.
                    </p>
                @endif
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('cv.pdf') }}" class="rounded-full bg-ink px-5 py-2.5 text-sm font-medium text-paper">Download CV</a>
                    <button type="button" data-email="{{ base64_encode($data->profile->email) }}" class="rounded-full border border-line bg-white/50 px-5 py-2.5 text-sm hover:border-clay/50">Email me</button>
                    @if ($data->profile->blog_url)
                        <a href="{{ $data->profile->blog_url }}" class="rounded-full border border-line bg-white/50 px-5 py-2.5 text-sm" target="_blank" rel="noreferrer">Read the blog</a>
                    @endif
                </div>
            </div>
            <div class="relative mx-auto w-full max-w-sm">
                <div class="absolute -inset-3 rounded-[2rem] bg-clay/15 md:-right-4 md:bottom-[-1.25rem] md:left-6 md:top-6"></div>
                @if ($data->profile->photo_path)
                    <img src="{{ asset($data->profile->photo_path) }}" alt="{{ $data->profile->name }}" class="relative aspect-[4/5] w-full rounded-[1.6rem] object-cover object-top shadow-sm">
                @endif
            </div>
        </section>

        <section class="border-y border-line bg-mist/70">
            <div class="mx-auto grid max-w-6xl grid-cols-2 gap-8 px-5 py-10 md:grid-cols-4 md:px-8">
                <div>
                    <p class="font-display text-4xl font-medium">{{ $data->yearsOfExperience() }}+</p>
                    <p class="mt-1 text-sm text-ink/60">years building software</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium">{{ $data->experiences->count() }}</p>
                    <p class="mt-1 text-sm text-ink/60">roles across the career timeline</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium">{{ $data->featuredProjects->count() }}</p>
                    <p class="mt-1 text-sm text-ink/60">selected projects on this page</p>
                </div>
                <div>
                    <p class="font-display text-4xl font-medium">{{ $data->profile->blog_url ? 2 : 1 }}</p>
                    <p class="mt-1 text-sm text-ink/60">public destinations for work and writing</p>
                </div>
            </div>
        </section>

        <section id="about" class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">01 — About</p>
            <div class="mt-4 grid gap-10 md:grid-cols-[0.7fr_1.3fr]">
                <h2 class="font-display text-4xl font-medium leading-tight">A full-stack engineer who ships CMS platforms, APIs, and product sites.</h2>
                <p class="max-w-2xl text-lg leading-8 text-ink/75">{{ $data->resolve($data->profile->bio) }}</p>
            </div>
        </section>

        <section id="experience" class="border-y border-line bg-white/40">
            <div class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">02 — Experience</p>
                <h2 class="font-display mt-3 text-4xl font-medium">Work history</h2>
                <ol class="timeline mt-12 space-y-10">
                    @foreach ($data->experiences as $experience)
                        <li class="relative grid gap-2 pl-7 md:grid-cols-[8.5rem_1fr] md:gap-12 md:pl-0">
                            <span class="timeline-dot"></span>
                            <p class="pt-0.5 text-sm text-ink/50">{{ $experience->periodLabel() }}</p>
                            <div>
                                <h3 class="text-xl font-semibold">{{ $experience->title }}</h3>
                                <p class="mt-1 text-clay">
                                    @if ($experience->company->website)
                                        <a href="{{ $experience->company->website }}" target="_blank" rel="noreferrer">{{ $experience->company->name }}</a>
                                    @else
                                        {{ $experience->company->name }}
                                    @endif
                                    @if ($experience->company->former_name)
                                        <span class="text-ink/45">· formerly {{ $experience->company->former_name }}</span>
                                    @endif
                                </p>
                                @if ($experience->summary)
                                    <p class="mt-3 text-ink/75">{{ $experience->summary }}</p>
                                @endif
                                @if ($experience->responsibilities)
                                    <ul class="mt-4 space-y-1.5 text-ink/70">
                                        @foreach ($experience->responsibilities as $item)
                                            <li class="flex gap-3">
                                                <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-clay"></span>
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

        <section id="work" class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">03 — Selected work</p>
            <h2 class="font-display mt-3 text-4xl font-medium">Projects worth opening</h2>
            <div class="mt-10 grid gap-5 md:grid-cols-2">
                @foreach ($data->featuredProjects as $project)
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-line bg-white/60 transition hover:-translate-y-0.5 hover:border-clay/40 hover:shadow-sm">
                        <div class="relative aspect-[16/9] overflow-hidden border-b border-line">
                            @if ($project->thumbnailUrl())
                                <img src="{{ $project->thumbnailUrl() }}" alt="{{ $project->name }}" loading="lazy" class="h-full w-full object-cover object-top transition duration-500 group-hover:scale-[1.03]">
                            @else
                                <div class="project-monogram">{{ $project->initials() }}</div>
                            @endif
                            <span class="absolute left-4 top-4 rounded-full bg-paper/90 px-2.5 py-1 text-[11px] uppercase tracking-wider text-ink/60 backdrop-blur">{{ $project->kind }}</span>
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-2xl font-semibold tracking-tight">
                                @if ($project->url)
                                    <a href="{{ $project->url }}" class="group-hover:text-clay" target="_blank" rel="noreferrer">{{ $project->name }}</a>
                                @else
                                    {{ $project->name }}
                                @endif
                            </h3>
                            @if ($project->company)
                                <p class="mt-1 text-sm text-ink/50">{{ $project->company->name }}</p>
                            @endif
                            @if ($project->summary)
                                <p class="mt-3 text-ink/75">{{ $project->summary }}</p>
                            @endif
                            @if ($project->technologies)
                                <div class="mt-5 flex flex-wrap gap-2 pt-1">
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

        <section class="border-y border-line bg-mist/70">
            <div class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">04 — Skills</p>
                <h2 class="font-display mt-3 text-4xl font-medium">Tools I reach for</h2>
                <div class="mt-10 grid gap-8 md:grid-cols-2">
                    @foreach ($data->skillCategories as $category)
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-ink/50">{{ $category->name }}</h3>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($category->skills as $skill)
                                    <span class="chip">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if ($data->profile->blog_url)
            <section id="writing" class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">05 — Writing</p>
                <div class="mt-4 grid items-end gap-8 md:grid-cols-[1.2fr_0.8fr]">
                    <div>
                        <h2 class="font-display text-4xl font-medium leading-tight md:text-5xl">Longer notes live on {{ $blogName }}</h2>
                        <p class="mt-4 max-w-xl text-lg leading-8 text-ink/70">This profile is for career highlights and selected work. The writing site keeps longer notes in their own focused home.</p>
                    </div>
                    <a href="{{ $data->profile->blog_url }}" class="inline-flex items-center justify-between rounded-3xl bg-ink px-6 py-5 text-paper transition hover:bg-clay" target="_blank" rel="noreferrer">
                        <span>
                            <span class="block text-sm text-paper/60">Read</span>
                            <span class="font-display text-2xl">{{ $blogName }}</span>
                        </span>
                        <span class="text-2xl">→</span>
                    </a>
                </div>
            </section>
        @endif

        <section id="background" class="border-t border-line">
            <div class="mx-auto max-w-6xl px-5 py-16 md:px-8 md:py-20">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">06 — Background</p>
                <h2 class="font-display mt-3 text-4xl font-medium">School, certifications, and the rest</h2>
                <div class="mt-10 grid items-start gap-5 md:grid-cols-2">
                    @if ($data->educations->isNotEmpty())
                        <div class="panel">
                            <h3 class="panel-title">Education</h3>
                            <ul class="mt-5 divide-y divide-line">
                                @foreach ($data->educations as $education)
                                    <li class="py-4 first:pt-0 last:pb-0">
                                        <p class="font-medium">{{ $education->credential }}</p>
                                        <p class="text-ink/65">{{ $education->institution }}</p>
                                        <p class="mt-1 text-sm text-ink/45">{{ $education->started_on?->format('Y') }}–{{ $education->ended_on?->format('Y') }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($data->certifications->isNotEmpty())
                        <div class="panel">
                            <h3 class="panel-title">Certifications</h3>
                            <ul class="mt-5 divide-y divide-line">
                                @foreach ($data->certifications as $certification)
                                    <li class="flex items-baseline justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                        <span>
                                            <span class="block font-medium">{{ $certification->name }}</span>
                                            <span class="block text-ink/65">{{ $certification->organization }}{{ $certification->result ? ' · '.$certification->result : '' }}</span>
                                        </span>
                                        <span class="shrink-0 text-sm text-ink/45">{{ $certification->awarded_on?->format('Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($data->trainings->isNotEmpty())
                        <div class="panel">
                            <h3 class="panel-title">Training</h3>
                            <ul class="mt-5 divide-y divide-line">
                                @foreach ($data->trainings as $training)
                                    <li class="py-4 first:pt-0 last:pb-0">
                                        <p class="font-medium">{{ $training->name }}</p>
                                        @if ($training->organization)
                                            <p class="text-ink/65">{{ $training->organization }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($data->interests->isNotEmpty())
                        <div class="panel">
                            <h3 class="panel-title">Interests</h3>
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($data->interests as $interest)
                                    <span class="chip">{{ $interest->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer id="contact" class="bg-ink text-paper">
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-[1.2fr_0.8fr] md:px-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-clay">Get in touch</p>
                <h2 class="font-display mt-3 text-4xl font-medium">{{ $data->profile->name }}</h2>
                <p class="mt-3 text-paper/65">{{ $data->profile->location }}</p>
                <button type="button" data-email="{{ base64_encode($data->profile->email) }}" class="mt-6 inline-flex items-center gap-2 rounded-full border border-paper/25 px-5 py-2.5 text-sm hover:border-clay hover:text-clay">
                    Email me
                    <span aria-hidden="true">→</span>
                </button>
                <p class="mt-3 text-sm text-paper/45">The address opens in your mail app — it is kept out of the page to deter scrapers.</p>
            </div>
            <div class="flex flex-col justify-between gap-6">
                <div class="flex flex-wrap gap-4 text-sm">
                    @if ($data->profile->blog_url)
                        <a href="{{ $data->profile->blog_url }}" class="underline decoration-paper/30 underline-offset-4 hover:text-clay" target="_blank" rel="noreferrer">Blog</a>
                    @endif
                    @if ($data->profile->github_url)
                        <a href="{{ $data->profile->github_url }}" class="underline decoration-paper/30 underline-offset-4 hover:text-clay" target="_blank" rel="noreferrer">GitHub</a>
                    @endif
                    @if ($data->profile->linkedin_url)
                        <a href="{{ $data->profile->linkedin_url }}" class="underline decoration-paper/30 underline-offset-4 hover:text-clay" target="_blank" rel="noreferrer">LinkedIn</a>
                    @endif
                    <a href="{{ route('cv.pdf') }}" class="underline decoration-paper/30 underline-offset-4 hover:text-clay">CV PDF</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
