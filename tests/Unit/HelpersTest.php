<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Series;
use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear permisos y roles antes de cada prueba
        UserHelper::createPermissions();
    }

    public function test_can_create_default_user()
    {
        // Llamamos al helper para crear el usuario por defecto
        $user = UserHelper::createDefaultUser();

        // Verificamos que el usuario se haya creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => config('users.default_user.name'),
            'email' => config('users.default_user.email'),
            'current_team_id' => $user->current_team_id,
        ]);

        // Verificamos que la contraseña almacenada sea válida
        $this->assertTrue(Hash::check(
            config('users.default_user.password'),
            $user->password
        ));

        // Verificamos que el equipo personal se haya creado correctamente
        $this->assertDatabaseHas('teams', [
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
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
            'current_team_id' => $teacher->current_team_id,
        ]);

        // Verificamos que la contraseña almacenada sea válida
        $this->assertTrue(Hash::check(
            config('users.default_teacher.password'),
            $teacher->password
        ));

        // Verificamos que el equipo personal se haya creado correctamente
        $this->assertDatabaseHas('teams', [
            'name' => $teacher->name . "'s Team",
            'user_id' => $teacher->id,
            'personal_team' => true,
        ]);
    }

    public function test_can_create_default_video()
    {
        // 1. Crear usuario admin
        $adminUser = User::factory()->create(['id' => 5]);

        // 2. Crear LAS 3 SERIES QUE NECESITAN LOS VIDEOS
        Series::factory()->create(['id' => 1]);
        Series::factory()->create(['id' => 2]);
        Series::factory()->create(['id' => 3]);

        // 3. Llamar al helper
        $videos = VideoHelper::createDefaultVideos();

        // 4. Verificar solo el primer video (de la serie 1)
        $this->assertDatabaseHas('videos', [
            'title' => 'Gol de Barou Shouei',
            'series_id' => 1,
            'user_id' => 5,
        ]);
    }
}
