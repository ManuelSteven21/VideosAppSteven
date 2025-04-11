<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\UserHelper;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Users\UsersManageControllerTest;


class UsersManageController extends Controller
{
    /**
     * Llista tots els usuaris per a la gestió.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->can('manage-users')) {
            \Log::info('User does not have permission to manage users');
            abort(403, 'No tens permisos per gestionar usuaris.');
        }

        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.manage.index', compact('users'));
    }

    public function create()
    {
        // Mostrar la vista para crear un nou usuari
        return view('users.manage.create');  // Puedes personalizar la ruta de la vista
    }

    /**
     * Guarda un nou usuari a la base de dades.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:regular,video_manager,super_admin',
        ]);

        // Asignar valor de super_admin en función del rol seleccionado
        $superAdmin = ($request->role == 'super_admin') ? true : false;

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'super_admin' => $superAdmin,  // Asignamos el valor de super_admin
        ]);

        // Asignar el rol correspondiente (utilizando el Helper)
        UserHelper::assignRole($user, $request->role);

        // Crear el equipo personal para el usuario
        UserHelper::addPersonalTeam($user);

        return redirect()->route('users.manage.index')->with('success', 'Usuari creat correctament.');
    }


    /**
     * Mostra la vista d'edició d'un usuari.
     */
    public function edit($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-users')) {
            \Log::info('User does not have permission to edit users');
            abort(403, 'No tens permisos per gestionar usuaris.');
        }

        $user = User::findOrFail($id);
        return view('users.manage.edit', compact('user'));
    }

    /**
     * Actualitza un usuari existent.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-users')) {
            \Log::info('User does not have permission to update users');
            abort(403, 'No tens permisos per gestionar usuaris.');
        }

        $user = User::findOrFail($id);

        // Validar los campos
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'sometimes|required|string|in:regular,video_manager,super_admin',
            'changePassword' => 'nullable|boolean', // Campo para saber si quiere cambiar la contraseña
        ]);

        // Si se desea cambiar la contraseña, encriptarla
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Si no se cambia la contraseña, no modificar el campo
        }

        // Actualizar el rol y el campo 'super_admin'
        if (isset($validatedData['role']) && $validatedData['role'] == 'super_admin') {
            // Si el rol es super_admin, marcar el campo 'super_admin' como true
            $validatedData['super_admin'] = true;
        } else {
            // Si no es super_admin, asegurarse de que el campo 'super_admin' esté como false
            $validatedData['super_admin'] = false;
        }

        // Actualizar el usuario con los datos validados
        $user->update($validatedData);

        // Si el rol fue modificado, se debe asignar el nuevo rol utilizando el Helper
        if (isset($validatedData['role'])) {
            UserHelper::assignRole($user, $validatedData['role']);
        }

        return redirect()->route('users.manage.index')->with('success', 'Usuari actualitzat correctament.');
    }


    /**
     * Mostra la vista de confirmació per eliminar un usuari.
     */
    public function delete($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-users')) {
            \Log::info('User does not have permission to delete users');
            abort(403, 'No tens permisos per gestionar usuaris.');
        }

        $user = User::findOrFail($id);
        return view('users.manage.delete', compact('user'));
    }

    /**
     * Elimina un usuari de la base de dades.
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->can('manage-users')) {
            \Log::info('User does not have permission to delete users');
            abort(403, 'No tens permisos per gestionar usuaris.');
        }

        $user = User::findOrFail($id);

        // Verificar si el usuario que se va a eliminar es el autenticado
        $isSelf = auth()->id() === $user->id;

        $user->delete();

        if ($isSelf) {
            // Cerrar sesión y redirigir a videos.index si el usuario se ha eliminado a sí mismo
            auth()->logout();
            return redirect()->route('videos.index')->with('success', 'El teu compte s\'ha eliminat correctament.');
        }

        return redirect()->route('users.manage.index')->with('success', 'Usuari eliminat correctament.');
    }


    /**
     * Retorna el test associat a aquest controlador.
     */
    public function testedBy(): string
    {
        return UsersManageControllerTest::class;
    }
}
