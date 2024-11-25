<?php

namespace Tests\Feature;

use App\Helpers\UserHelper;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_default_user()
    {
        // Llamamos al helper para crear el usuario por defecto
        $user = UserHelper::createDefaultUser();

        // Verificamos que el usuario se haya creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => config('users.default_user.name'),
            'email' => config('users.default_user.email'),
        ]);

        // Verificamos que el equipo personal se haya creado para el usuario
        $this->assertDatabaseHas('teams', [
            'name' => $user->name . "'s Team", // El nombre del equipo debe ser el del usuario + 's Team'
            'user_id' => $user->id,           // El user_id debe ser el del usuario creado
            'personal_team' => true,          // El equipo debe ser personal
        ]);
    }

    public function test_can_create_default_teacher()
    {
        // Llamamos al helper para crear el profesor por defecto
        $teacher = UserHelper::createDefaultTeacher();

        // Verificamos que el profesor se haya creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => config('users.default_teacher.name'),
            'email' => config('users.default_teacher.email'),
        ]);

        // Verificamos que el equipo personal se haya creado para el profesor
        $this->assertDatabaseHas('teams', [
            'name' => $teacher->name . "'s Team", // El nombre del equipo debe ser el del profesor + 's Team'
            'user_id' => $teacher->id,           // El user_id debe ser el del profesor creado
            'personal_team' => true,             // El equipo debe ser personal
        ]);
    }
}
