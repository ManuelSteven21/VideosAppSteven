<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use Tests\Unit\VideosTest;

class VideosController extends Controller
{
    /**
     * Llista tots els vídeos disponibles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtenir tots els vídeos ordenats per data de publicació (més recents primer)
        $videos = Video::orderBy('published_at', 'desc')->get();

        // Retornar la vista amb els vídeos
        return view('videos.index', compact('videos'));
    }

    /**
     * Mostra la informació d'un vídeo específic.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $video = Video::with('user')->findOrFail($id); // Carga la relación
        $previous = $video->getPrevious();
        $next = $video->getNext();

        return view('videos.show', [
            'video' => $video,
            'previous' => $previous,
            'next' => $next,
            'user' => $video->user // Pasa el usuario
        ]);
    }

    /**
     * Retorna la classe de test.
     *
     * @return string
     */
    public function testedBy(): string
    {
        return VideosTest::class;
    }
}
