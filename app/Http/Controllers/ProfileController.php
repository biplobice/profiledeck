<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\ProfileData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('home', ['data' => ProfileData::load()]);
    }

    public function projects(Request $request): View
    {
        $kind = $request->string('kind')->toString();
        $kind = array_key_exists($kind, Project::kindLabels()) ? $kind : null;

        $query = Project::query()
            ->visible()
            ->with('company')
            ->orderBy('sort_order')
            ->orderByDesc('started_on')
            ->orderBy('name');

        if ($kind) {
            $query->where('kind', $kind);
        }

        return view('projects', [
            'data' => ProfileData::load(),
            'kind' => $kind,
            'kindLabels' => Project::kindLabels(),
            'availableKinds' => Project::query()->visible()->distinct()->orderBy('kind')->pluck('kind'),
            'projects' => $query->paginate(12)->withQueryString(),
        ]);
    }

    public function cv(): View
    {
        return view('cv', ['data' => ProfileData::load()]);
    }

    public function pdf(): Response
    {
        $data = ProfileData::load();
        $filename = 'CV_'.str_replace(' ', '_', $data->profile->name).'.pdf';

        return Pdf::loadView('cv-pdf', ['data' => $data])
            ->setPaper('a4')
            ->download($filename);
    }
}
