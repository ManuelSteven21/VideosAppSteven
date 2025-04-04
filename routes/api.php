<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiMultimediaController;
use App\Http\Controllers\AuthController;

// Autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Multimedia - Rutas públicas
Route::get('/multimedia', [ApiMultimediaController::class, 'index']);
Route::get('/multimedia/{id}', [ApiMultimediaController::class, 'show']);

// Multimedia - Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/multimedia', [ApiMultimediaController::class, 'store']);
    Route::put('/multimedia/{id}', [ApiMultimediaController::class, 'update']);
    Route::delete('/multimedia/{id}', [ApiMultimediaController::class, 'destroy']);
    Route::get('/user/files', [ApiMultimediaController::class, 'userFiles']);

    Route::post('/multimedia/upload', [ApiMultimediaController::class, 'upload']);
    Route::patch('/multimedia/confirm/{id}', [ApiMultimediaController::class, 'confirmUpload']);

    // Eliminación si el usuario cancela la subida
    Route::delete('/multimedia/cancel-upload/{id}', [ApiMultimediaController::class, 'cancelUpload']);
});
