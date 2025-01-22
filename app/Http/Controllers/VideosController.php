<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    /**
     * Muestra la información de un video específico.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Busca el vídeo por ID
        $video = Video::find($id);

        // Si el vídeo no existe, retorna un error 404
        if (!$video) {
            abort(404, 'Video not found');
        }

        // Retorna la vista del vídeo con la información
        return view('videos.show', compact('video'));
    }

    /**
     * Retorna una lista de testers asociados al video.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function testedBy($id)
    {
        // Busca el video por ID
        $video = Video::find($id);

        // Si el video no existe, devuelve un error 404
        if (!$video) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        // Devuelve una lista ficticia de testers asociados al video
        // (sustituir este arreglo por la lógica real que desees implementar)
        $testers = [
            ['id' => 1, 'name' => 'Tester 1', 'email' => 'tester1@example.com'],
            ['id' => 2, 'name' => 'Tester 2', 'email' => 'tester2@example.com'],
        ];

        // Devuelve los testers en formato JSON
        return response()->json(['testers' => $testers], 200);
    }
}
