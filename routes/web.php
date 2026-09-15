<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/', [ProfileController::class, 'index'])->name('home');
Route::get('/projects', [ProfileController::class, 'projects'])->name('projects');
Route::get('/cv', [ProfileController::class, 'cv'])->name('cv');
Route::get('/cv.pdf', [ProfileController::class, 'pdf'])->name('cv.pdf');
