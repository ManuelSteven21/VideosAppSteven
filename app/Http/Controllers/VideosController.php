<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use Tests\Unit\VideosTest;

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

        if (!$video) {
            abort(404); // Return 404 if the video is not found
        }
        return view('videos.show', compact('video'));
    }

    public function manage()
    {
        return view('videos.manage');
    }

    public function testedBy():string
    {
        return VideosTest::class;
    }
}
