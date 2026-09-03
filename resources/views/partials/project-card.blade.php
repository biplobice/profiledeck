<article class="project-card">
    <div class="project-card-media">
        @if ($project->thumbnailUrl())
            <img src="{{ $project->thumbnailUrl() }}" alt="{{ $project->name }}" loading="lazy">
        @else
            <div class="project-monogram">{{ $project->initials() }}</div>
        @endif
        <span class="project-kind">{{ $project->kindLabel() }}</span>
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
