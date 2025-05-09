<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Tests\Feature\Videos\VideosManageControllerTest;

class VideosManageController extends Controller
{
    public function __construct()
    {
        // Aplica la comprovació només als mètodes indicats
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user->can('manage-videos') && !$user->can('create-videos')) {
                abort(403, 'No tens permisos per accedir a aquesta secció de vídeos.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'delete', 'destroy']);
    }
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
    public function create(Request $request)
    {
        session(['video_creation_referer' => $request->headers->get('referer')]);
        // Cargar todas las series, ordenadas por título (puedes modificar el orden si lo deseas)
        $series = \App\Models\Series::orderBy('title')->get();
        // Ahora pasamos la variable $series a la vista
        return view('videos.manage.create', compact('series'));
    }


    /**
     * Emmagatzema un nou vídeo a la base de dades.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|url',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['published_at'] = now();

        if (!isset($validatedData['series_id'])) {
            $validatedData['series_id'] = null;
        }

        $video = Video::create($validatedData);

        // 🔔 Dispara l'event aquí
        \Log::info('Disparant event VideoCreated...');
        event(new \App\Events\VideoCreated($video));

        return redirect()->route('videos.show', $video->id)->with('success', 'Vídeo creat correctament.');
    }




    /**
     * Mostra la vista d'edició d'un vídeo.
     */
    public function edit(Request $request, $id)
    {
        session(['video_edition_referer' => $request->headers->get('referer')]);
        $video = Video::findOrFail($id);
        $this->authorize('update', $video);
        $series = \App\Models\Series::orderBy('title')->get();
        return view('videos.manage.edit', compact('video','series'));
    }

    /**
     * Actualitza un vídeo existent.
     */
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $validatedData = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'sometimes|required|url',
            'published_at'=> 'nullable|date',
            'previous'    => 'nullable|string',
            'next'        => 'nullable|string',
            'series_id'   => 'nullable|exists:series,id',
        ]);

        // Conserva el user_id original o asigna otro que haga sentido
        $validatedData['user_id'] = $video->user_id;
        $video->update($validatedData);

        $referer = session('video_edition_referer');
        session()->forget('video_edition_referer');

        if (str_contains($referer, route('videos.manage.index'))) {
            return redirect()->route('videos.manage.index')
                ->with('success', 'Vídeo actualitzat correctament.');
        }


        // Redirigir al show del vídeo actualizado
        return redirect()->route('videos.show', $video->id)->with('success', 'Vídeo actualitzat correctament.');
    }


    /**
     * Mostra la vista de confirmació per eliminar un vídeo.
     */
    public function delete(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $this->authorize('delete', $video);
        session(['video_deletion_referer' => $request->headers->get('referer')]);
        return view('videos.manage.delete', compact('video'));
    }

    /**
     * Elimina un vídeo de la base de dades.
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        $referer = session('video_deletion_referer');
        session()->forget('video_deletion_referer');

        if (str_contains($referer, route('videos.manage.index'))) {
            return redirect()->route('videos.manage.index')
                ->with('success', 'Vídeo eliminat correctament.');
        }

        return redirect()->route('videos.index')->with('success', 'Vídeo eliminat correctament.');
    }

    public function testedBy(): string
    {
        return VideosManageControllerTest::class;
    }
}
