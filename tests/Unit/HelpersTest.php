<?php

namespace Tests\Unit;

use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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
            'current_team_id' => $user->current_team_id, // Usamos el equipo asignado dinámicamente
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
            'current_team_id' => $teacher->current_team_id, // Usamos el equipo asignado dinámicamente
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
        // Llamamos al helper para crear los videos por defecto
        $videos = VideoHelper::createDefaultVideos();

        // Seleccionamos el primer video creado
        $video = $videos->first();

        // Verificamos que el video se haya creado correctamente en la base de datos
        $this->assertDatabaseHas('videos', [
            'title' => config('videos.video_1.title'),
            'description' => config('videos.video_1.description'),
            'url' => config('videos.video_1.url'),
            'series_id' => 1, // Valor esperado manualmente
        ]);

        // Verificamos el formato personalizado de la fecha publicada
        $formattedDate = $video->formatted_published_at;
        $this->assertNotNull($formattedDate);
        $this->assertEquals(now()->isoFormat('D [de] MMMM [de] YYYY'), $formattedDate);
    }




}
