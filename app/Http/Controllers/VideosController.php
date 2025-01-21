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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Busca el vídeo per ID
        $video = Video::find($id);

        // Si el vídeo no existeix, retorna un error 404
        if (!$video) {
            abort(404, 'Video not found');
        }

        // Retorna la vista del vídeo amb la informació
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

        // Si no necesitas la relación, simplemente devuelve los datos relacionados al video
        return response()->json([
            'id' => $video->id,
            'title' => $video->title,
            'description' => $video->description,
        ]);
    }

}
