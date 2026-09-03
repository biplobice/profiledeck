@extends('layouts.site')

@section('title', 'Projects — '.$data->profile->name)
@section('description', 'Published projects by '.$data->profile->name.'.')

@section('header')
    @include('partials.site-header', ['data' => $data])
@endsection

@section('content')
    <section class="site-shell section projects-page">
        <div class="section-heading">
            <div>
                <p class="eyebrow">All published work</p>
                <h2>Projects</h2>
            </div>
            <a href="{{ route('home') }}#work" class="btn btn-ghost">Selected work</a>
        </div>

        @if ($availableKinds->count() > 1)
            <nav class="filter-row" aria-label="Filter projects by kind">
                <a href="{{ route('projects') }}" class="filter-chip{{ $kind === null ? ' is-active' : '' }}">All</a>
                @foreach ($availableKinds as $availableKind)
                    <a
                        href="{{ route('projects', ['kind' => $availableKind]) }}"
                        class="filter-chip{{ $kind === $availableKind ? ' is-active' : '' }}"
                    >{{ $kindLabels[$availableKind] ?? ucfirst($availableKind) }}</a>
                @endforeach
            </nav>
        @endif

        <p class="projects-count">
            {{ $projects->total() }} {{ $projects->total() === 1 ? 'project' : 'projects' }}
            @if ($kind)
                in {{ strtolower($kindLabels[$kind] ?? $kind) }}
            @endif
        </p>

        @if ($projects->isEmpty())
            <p class="projects-empty">No published projects in this group yet.</p>
        @else
            <div class="project-grid">
                @foreach ($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif

        @if ($projects->hasPages())
            <nav class="pager" aria-label="Project pages">
                @if ($projects->onFirstPage())
                    <span class="pager-link is-disabled">Previous</span>
                @else
                    <a class="pager-link" href="{{ $projects->previousPageUrl() }}">Previous</a>
                @endif

                <ol class="pager-pages">
                    @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                        <li>
                            @if ($page === $projects->currentPage())
                                <span class="pager-link is-active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pager-link" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                </ol>

                @if ($projects->hasMorePages())
                    <a class="pager-link" href="{{ $projects->nextPageUrl() }}">Next</a>
                @else
                    <span class="pager-link is-disabled">Next</span>
                @endif
            </nav>
        @endif
    </section>
@endsection

@section('footer')
    @include('partials.site-footer', ['data' => $data])
@endsection
