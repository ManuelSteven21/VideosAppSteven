<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use App\Helpers\UserHelper;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $teacher;


    protected function setUp(): void
    {
        parent::setUp();

        // Crear permisos i rols
        UserHelper::createPermissions();

        // Crear l'usuari teacher
        $this->teacher = UserHelper::createDefaultTeacher();
    }

    public function test_users_can_view_videos()
    {
        // Autenticar l'usuari teacher
        $this->actingAs($this->teacher);

        // Crear un vídeo
        $video = Video::factory()->create();

        // Fer la petició per veure el vídeo
        $response = $this->get(route('videos.show', $video->id));

        // Verificar que la resposta és correcta
        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('video', $video);
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        // Autenticar l'usuari teacher
        $this->actingAs($this->teacher);

        // Fer la petició per veure un vídeo que no existeix
        $response = $this->get(route('videos.show', 9999));

        // Verificar que la resposta és un 404
        $response->assertStatus(404);
    }
}
