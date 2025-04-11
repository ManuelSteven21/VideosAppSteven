<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;


class SeriesController extends Controller
{
    /**
     * Mostra totes les sèries ordenades per data de publicació.
     */
    public function index(Request $request)
    {
        $query = Series::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        $series = $query->latest()->get();

        return view('series.index', compact('series'));
    }

    /**
     * Mostra els detalls d'una sèrie específica i els seus vídeos associats.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Cargar la serie con los videos asociados ordenados
        $series = Series::with(['videos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('series.show', compact('series'));
    }
}
