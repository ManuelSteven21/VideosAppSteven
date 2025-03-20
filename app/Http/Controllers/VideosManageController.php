<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Tests\Feature\Videos\VideosManageControllerTest;

class VideosManageController extends Controller
{
    /**
     * Llista tots els vídeos per a la gestió.
     */
    public function manage()
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        $videos = Video::orderBy('published_at', 'desc')->get();
        return view('videos.manage.index', compact('videos'));

    }

    /**
     * Mostra el formulari per crear un nou vídeo.
     */
    public function create()
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        return view('videos.manage.create');
    }

    /**
     * Emmagatzema un nou vídeo a la base de dades.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
            // No es necesario incluir series_id ni published_at en la validación
        ]);

        // 🔹 Assegurar que `user_id` es guarda correctament
        $validatedData['user_id'] = auth()->id();
        $validatedData['series_id'] = 1; // Valor predeterminat per `series_id`
        $validatedData['published_at'] = now(); // Valor per `published_at`

        Video::create($validatedData);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo creat correctament.');
    }



    /**
     * Mostra la vista d'edició d'un vídeo.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }


        $video = Video::findOrFail($id);
        return view('videos.manage.edit', compact('video'));
    }

    /**
     * Actualitza un vídeo existent.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        $video = Video::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'sometimes|required|url',
            'published_at' => 'nullable|date',
            'previous' => 'nullable|string',
            'next' => 'nullable|string',
            'series_id' => 'sometimes|required|integer'
        ]);

        // 🔹 Assegurar que `user_id` no es perdi
        $validatedData['user_id'] = $video->user_id;

        $video->update($validatedData);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo actualitzat correctament.');
    }


    /**
     * Mostra la vista de confirmació per eliminar un vídeo.
     */
    public function delete($id)
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        $video = Video::findOrFail($id);
        return view('videos.manage.delete', compact('video'));
    }

    /**
     * Elimina un vídeo de la base de dades.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('manage-videos')) {
            \Log::info('User does not have permission to manage videos');
            abort(403, 'No tens permisos per gestionar vídeos.');
        }

        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo eliminat correctament.');
    }

    public function testedBy(): string
    {
        return VideosManageControllerTest::class;
    }
}
