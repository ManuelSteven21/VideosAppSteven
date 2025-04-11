<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Mostra una llista de tots els usuaris.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Filtra els usuaris segons el terme de cerca (nom o email)
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->paginate(10); // Paginació per a 10 usuaris per pàgina

        return view('users.index', compact('users'));
    }

    /**
     * Mostra els detalls d'un usuari específic.
     */
    public function show($id)
    {
        $user = User::with(['videos' => function($query) {
            $query->with('user') // Asegúrate de cargar la relación user
            ->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('users.show', compact('user'));
    }

}
