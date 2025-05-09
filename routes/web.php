<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\VideosManageController;
use App\Http\Controllers\UsersManageController;
use App\Http\Controllers\SeriesManageController;

Route::get('/', function () {
    return redirect()->route('videos.index');
});

// Rutes per veure vídeos (no necessiten permisos especials)
Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');
Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');

// Rutes per veure usuaris (només per usuaris autenticats)
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
});

// Rutes per gestionar vídeos (requereixen permisos)
Route::middleware(['auth', 'can:manage-videos'])->group(function () {
    Route::get('/videosmanage', [VideosManageController::class, 'manage'])->name('videos.manage.index');
});

// Per a manage-videos o create-videos
Route::middleware(['auth'])->group(function () {
    Route::get('/videos/manage/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
    Route::post('/videos/manage', [VideosManageController::class, 'store'])->name('videos.manage.store');
    Route::get('/videos/manage/{id}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
    Route::put('/videos/manage/{id}', [VideosManageController::class, 'update'])->name('videos.manage.update');
    Route::get('/videos/manage/{id}/delete', [VideosManageController::class, 'delete'])->name('videos.manage.delete');
    Route::delete('/videos/manage/{id}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
});


Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::get('/usersmanage', [UsersManageController::class, 'index'])->name('users.manage.index');
    Route::get('/users/manage/create', [UsersManageController::class, 'create'])->name('users.manage.create');
    Route::post('/users/manage', [UsersManageController::class, 'store'])->name('users.manage.store');
    Route::get('/users/manage/{id}/edit', [UsersManageController::class, 'edit'])->name('users.manage.edit');
    Route::put('/users/manage/{id}', [UsersManageController::class, 'update'])->name('users.manage.update');
    Route::get('/users/manage/{id}/delete', [UsersManageController::class, 'delete'])->name('users.manage.delete');
    Route::delete('/users/manage/{id}', [UsersManageController::class, 'destroy'])->name('users.manage.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/{id}', [SeriesController::class, 'show'])->name('series.show');
});

Route::middleware(['auth', 'can:manage-series'])->group(function () {
    Route::get('/seriesmanage', [SeriesManageController::class, 'index'])->name('series.manage.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/series/manage/create', [SeriesManageController::class, 'create'])->name('series.manage.create');
    Route::post('/series/manage', [SeriesManageController::class, 'store'])->name('series.manage.store');
    Route::get('/series/manage/{id}/edit', [SeriesManageController::class, 'edit'])->name('series.manage.edit');
    Route::put('/series/manage/{id}', [SeriesManageController::class, 'update'])->name('series.manage.update');
    Route::get('/series/manage/{id}/delete', [SeriesManageController::class, 'delete'])->name('series.manage.delete');
    Route::delete('/series/manage/{id}', [SeriesManageController::class, 'destroy'])->name('series.manage.destroy');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('videos.index');
    })->name('dashboard');
});

Route::get('/notifications', function () {
    return view('notifications');
});

// routes/web.php
Route::middleware('auth')->get('/api/notifications', function () {
    return auth()->user()->notifications;
});
