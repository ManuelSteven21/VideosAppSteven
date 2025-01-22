<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Configurar la clave de aplicación para el entorno de pruebas
        config(['app.key' => 'base64:' . base64_encode(random_bytes(32))]);
    }

    public function test_users_can_view_videos()
    {
        $video = Video::factory()->create();

        $response = $this->get(route('videos.show', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('video', $video);
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        $response = $this->get(route('videos.show', 9999));

        $response->assertStatus(404);
    }
}
