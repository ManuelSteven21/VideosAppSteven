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
        // Busca el vídeo per ID
        $video = Video::find($id);

        // Si el vídeo no existeix, retorna un error 404
        if (!$video) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        // Obté els tests associats al vídeo
        $tests = $video->tests()->get(); // Assumeix que hi ha una relació definida a Video

        // Retorna els tests en format JSON
        return response()->json(['tests' => $tests], 200);
    }
}
