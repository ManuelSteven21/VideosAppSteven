<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Tests\Feature\Series\SeriesManageControllerTest;

class SeriesManageController extends Controller
{
    /**
     * Llista totes les sèries per a la gestió.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->can('manage-series')) {
            \Log::info('User does not have permission to manage series');
            abort(403, 'No tens permisos per gestionar sèries.');
        }

        $series = Series::orderBy('created_at', 'desc')->get();
        return view('series.manage.index', compact('series'));
    }

    /**
     * Mostra el formulari per crear una nova sèrie.
     */
    public function create()
    {
        return view('series.manage.create');
    }

    /**
     * Desa una nova sèrie a la base de dades.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url|max:2048',
        ]);


        $series = new Series();
        $series->title = $request->title;
        $series->description = $request->description;
        $series->published_at = now();

        // Dades de l'usuari autenticat
        $user = auth()->user();
        $series->user_name = $user->name;
        $series->user_photo_url = $user->profile_photo_url;

        // Guardar URL de la imatge
        if ($request->filled('image')) {
            $series->image = $request->image;
        }

        $series->save();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie creada correctament.');
    }


    /**
     * Mostra el formulari per editar una sèrie existent.
     */
    public function edit($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-series')) {
            \Log::info('User does not have permission to edit series');
            abort(403, 'No tens permisos per gestionar sèries.');
        }

        $series = Series::findOrFail($id);
        return view('series.manage.edit', compact('series'));
    }

    /**
     * Actualitza una sèrie existent.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-series')) {
            \Log::info('User does not have permission to update series');
            abort(403, 'No tens permisos per gestionar sèries.');
        }

        $series = Series::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url|max:2048',
        ]);

        $series->title = $request->title;
        $series->description = $request->description;

        if ($request->filled('image')) {
            $series->image = $request->image;
        }

        $series->save();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie actualitzada correctament.');
    }



    /**
     * Mostra la vista de confirmació per eliminar una sèrie.
     */
    public function delete($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-series')) {
            \Log::info('User does not have permission to delete series');
            abort(403, 'No tens permisos per gestionar sèries.');
        }

        $series = Series::findOrFail($id);
        return view('series.manage.delete', compact('series'));
    }

    /**
     * Elimina una sèrie de la base de dades.
     * També pot opcionalment desassignar els vídeos relacionats.
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-series')) {
            \Log::info('User does not have permission to destroy series');
            abort(403, 'No tens permisos per gestionar sèries.');
        }

        $series = Series::findOrFail($id);

        // Opcional: desassignar vídeos en lloc d'eliminar-los
        foreach ($series->videos as $video) {
            $video->series_id = null;
            $video->save();
        }

        $series->delete();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie eliminada correctament.');
    }

    /**
     * Retorna el test associat a aquest controlador.
     */
    public function testedBy(): string
    {
        return SeriesManageControllerTest::class;
    }
}
