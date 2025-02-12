<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas o accesibles sin autenticación
Route::middleware('auth')->group(function () {
    Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
    Route::get('/videos/manage', [VideosController::class, 'manage'])->name('videos.manage');
});

// Rutas protegidas con autenticación y verificación adicional de permisos
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
