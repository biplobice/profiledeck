<?php

namespace App\Http\Controllers;

use App\Support\ProfileData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('home', ['data' => ProfileData::load()]);
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
