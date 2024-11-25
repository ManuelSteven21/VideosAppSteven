<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class UserHelper
{
    public static function createDefaultUser()
    {
        // Crear el usuario
        $user = User::create([
            'name' => config('users.default_user.name'),
            'email' => config('users.default_user.email'),
            'password' => Hash::make(config('users.default_user.password')),
        ]);

        // Crear el equipo personal
        $team = Team::create([
            'name' => $user->name . "'s Team", // Nombre del equipo
            'user_id' => $user->id,           // ID del propietario
            'personal_team' => true,          // Marcado como equipo personal
        ]);

        // Asignar el equipo actual al usuario
        $user->update(['current_team_id' => $team->id]);

        return $user;
    }

    public static function createDefaultTeacher()
    {
        // Crear el usuario
        $teacher = User::create([
            'name' => config('users.default_teacher.name'),
            'email' => config('users.default_teacher.email'),
            'password' => Hash::make(config('users.default_teacher.password')),
        ]);

        // Crear el equipo personal
        $team = Team::create([
            'name' => $teacher->name . "'s Team", // Nombre del equipo
            'user_id' => $teacher->id,           // ID del propietario
            'personal_team' => true,             // Marcado como equipo personal
        ]);

        // Asignar el equipo actual al usuario
        $teacher->update(['current_team_id' => $team->id]);

        return $teacher;
    }
}
