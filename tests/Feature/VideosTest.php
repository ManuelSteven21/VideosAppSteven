<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use App\Models\User;
use App\Models\Series;
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
        $this->actingAs($this->teacher);

        // 1. Crear serie necesaria
        $series = Series::factory()->create();

        // 2. Crear usuario y video asociados
        $user = User::factory()->create();
        $video = Video::factory()->create([
            'user_id' => $user->id,
            'series_id' => $series->id,
        ]);

        $response = $this->get(route('videos.show', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('video', $video);
    }

    public function test_users_cannot_view_non_existing_videos()
    {
        // Fer la petició per veure un vídeo que no existeix
        $response = $this->get(route('videos.show', 9999));

        // Verificar que la resposta és un 404
        $response->assertStatus(404);
    }
}
