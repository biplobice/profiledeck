<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileController::class, 'index'])->name('home');
Route::get('/cv', [ProfileController::class, 'cv'])->name('cv');
Route::get('/cv.pdf', [ProfileController::class, 'pdf'])->name('cv.pdf');
