<table class="header">
    <tr>
        <td>
            <h1>{{ $data->profile->name }}</h1>
            <p>{{ $data->profile->headline }}<br>{{ $data->profile->location }}</p>
            <p class="meta">
                {{ $data->profile->email }}
                @if ($data->profile->phone) · {{ $data->profile->phone }} @endif
                @if ($data->profile->website) · {{ $data->profile->website }} @endif
                @if ($data->profile->blog_url) · {{ $data->profile->blog_url }} @endif
                @if ($data->profile->github_url) · {{ $data->profile->github_url }} @endif
                @if ($data->profile->linkedin_url) · {{ $data->profile->linkedin_url }} @endif
            </p>
        </td>
        <td style="width: 80px; text-align: right;">
            @if ($data->profile->cv_photo_path && (! ($forPdf ?? false) || file_exists(public_path($data->profile->cv_photo_path))))
                <img
                    class="photo"
                    src="{{ ($forPdf ?? false) ? public_path($data->profile->cv_photo_path) : asset($data->profile->cv_photo_path) }}"
                    alt=""
                >
            @endif
        </td>
    </tr>
</table>

<h2>Summary</h2>
<p>{{ $data->resolve($data->profile->summary) }}</p>
<p>{{ $data->resolve($data->profile->bio) }}</p>

<h2>Experience</h2>
<table>
    @foreach ($data->experiences as $experience)
        <tr>
            <td class="dates">{{ $experience->periodLabel() }}</td>
            <td>
                <h3>{{ $experience->title }}</h3>
                <p>{{ $experience->company->displayName() }}</p>
                @if ($experience->responsibilities)
                    <ul>
                        @foreach ($experience->responsibilities as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif
                @if ($experience->achievements)
                    <p><strong>Achievements</strong></p>
                    <ul>
                        @foreach ($experience->achievements as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h2>Selected projects</h2>
<table>
    @foreach ($data->featuredProjects as $project)
        <tr>
            <td class="dates">{{ $project->kind }}</td>
            <td>
                <h3>{{ $project->name }}</h3>
                <p>
                    {{ $project->company?->name }}
                    @if ($project->url) · {{ $project->url }} @endif
                </p>
                @if ($project->summary)
                    <p>{{ $project->summary }}</p>
                @endif
                @if ($project->technologies)
                    <p class="meta">{{ collect($project->technologies)->join(', ') }}</p>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h2>Skills</h2>
<table>
    @foreach ($data->skillCategories as $category)
        <tr>
            <td class="dates">{{ $category->name }}</td>
            <td>{{ $category->skills->pluck('name')->join(', ') }}</td>
        </tr>
    @endforeach
</table>

<h2>Education</h2>
<table>
    @foreach ($data->educations as $education)
        <tr>
            <td class="dates">{{ $education->started_on?->format('Y') }}–{{ $education->ended_on?->format('Y') }}</td>
            <td>
                <h3>{{ $education->credential }}</h3>
                <p>{{ $education->institution }}</p>
            </td>
        </tr>
    @endforeach
</table>

<h2>Certifications</h2>
<table>
    @foreach ($data->certifications as $certification)
        <tr>
            <td class="dates">{{ $certification->awarded_on?->format('Y-m-d') }}</td>
            <td>
                <h3>{{ $certification->name }}</h3>
                <p>{{ $certification->organization }}{{ $certification->result ? ' — '.$certification->result : '' }}</p>
            </td>
        </tr>
    @endforeach
</table>

@if ($data->trainings->isNotEmpty())
    <h2>Training</h2>
    <ul>
        @foreach ($data->trainings as $training)
            <li>{{ $training->name }}@if ($training->organization) — {{ $training->organization }}@endif</li>
        @endforeach
    </ul>
@endif

@if ($data->interests->isNotEmpty())
    <h2>Interests</h2>
    <p>{{ $data->interests->pluck('name')->join(', ') }}</p>
@endif
