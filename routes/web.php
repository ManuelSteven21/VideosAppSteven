<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('videos/{id}', [VideosController::class, 'show'])->name('videos.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
