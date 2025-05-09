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
        if (!auth()->user()->can('create-series')) {
            abort(403);
        }
        return view('series.manage.create');
    }

    /**
     * Desa una nova sèrie a la base de dades.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create-series')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url|max:2048',
        ]);

        $series = new Series();
        $series->title = $request->title;
        $series->description = $request->description;
        $series->published_at = now();
        $series->user_name = auth()->user()->name;
        $series->user_photo_url = auth()->user()->profile_photo_url;
        $series->image = $request->image;
        $series->save();

        return redirect()->route('series.show', $series->id)->with('success', 'Sèrie creada correctament.');
    }


    /**
     * Mostra el formulari per editar una sèrie existent.
     */
    public function edit(Request $request, $id)
    {
        session(['series_edition_referer' => $request->headers->get('referer')]);

        $series = Series::findOrFail($id);
        $this->authorize('update', $series); // 👈 Asegura que sea el creador o tenga manage

        return view('series.manage.edit', compact('series'));
    }
    /**
     * Actualitza una sèrie existent.
     */
    public function update(Request $request, $id)
    {
        $series = Series::findOrFail($id);
        $this->authorize('update', $series); // 👈 También aquí

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

        $referer = session('series_edition_referer');
        session()->forget('series_edition_referer');

        if ($referer && str_contains($referer, route('series.manage.index'))) {
            return redirect()->route('series.manage.index')->with('success', 'Sèrie actualitzada correctament.');
        }

        return redirect()->route('series.show', $series->id)->with('success', 'Sèrie actualitzada correctament.');
    }



    /**
     * Mostra la vista de confirmació per eliminar una sèrie.
     */
    public function delete(Request $request, $id)
    {
        $series = Series::findOrFail($id);
        $this->authorize('delete', $series);
        session(['series_deletion_referer' => $request->headers->get('referer')]);

        return view('series.manage.delete', compact('series'));
    }

    /**
     * Elimina una sèrie de la base de dades.
     * També pot opcionalment desassignar els vídeos relacionats.
     */
    public function destroy($id)
    {
        $series = Series::findOrFail($id);
        $this->authorize('delete', $series);

        // Desvincular vídeos
        foreach ($series->videos as $video) {
            $video->series_id = null;
            $video->save();
        }

        $series->delete();

        $referer = session('series_deletion_referer');
        session()->forget('series_deletion_referer');

        if ($referer && str_contains($referer, route('series.manage.index'))) {
            return redirect()->route('series.manage.index')->with('success', 'Sèrie eliminada correctament.');
        }

        return redirect()->route('series.index')->with('success', 'Sèrie eliminada correctament.');
    }

    /**
     * Retorna el test associat a aquest controlador.
     */
    public function testedBy(): string
    {
        return SeriesManageControllerTest::class;
    }
}
