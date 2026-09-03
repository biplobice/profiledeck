<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CV — {{ $data->profile->name }}</title>
    <style>
        @page { margin: 18mm 16mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; line-height: 1.35; }
        h1 { font-size: 20px; margin: 0 0 2px; }
        h2 { font-size: 12px; margin: 14px 0 6px; border-bottom: 1px solid #bbb; padding-bottom: 3px; text-transform: uppercase; letter-spacing: 0.08em; }
        h3 { font-size: 11px; margin: 0; }
        p { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 0 0 8px; }
        .meta { color: #444; font-size: 9px; }
        .dates { width: 95px; color: #555; white-space: nowrap; }
        ul { margin: 4px 0 0 16px; padding: 0; }
        li { margin-bottom: 2px; }
        .header td { padding-bottom: 10px; }
        img.photo { width: 72px; height: 72px; }
    </style>
</head>
<body>
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
                @if ($data->profile->cv_photo_path && file_exists(public_path($data->profile->cv_photo_path)))
                    <img class="photo" src="{{ public_path($data->profile->cv_photo_path) }}" alt="">
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
</body>
</html>
