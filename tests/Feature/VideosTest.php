<?php

namespace Tests\Feature;

use App\Models\Video;
use Tests\TestCase;

class VideosTest extends TestCase
{
    public function test_users_can_view_videos()
    {
        // Crear un vídeo
        $video = Video::factory()->create();

        // Fer una petició GET a la ruta del vídeo
        $response = $this->get(route('videos.show', $video->id));

        // Comprovar que la petició retorna status 200
        $response->assertStatus(200);

        // Comprovar que la vista carregada és la correcta
        $response->assertViewIs('videos.show');

        // Comprovar que la vista té el model `video` passat correctament
        $response->assertViewHas('video', $video);
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        // Fer una petició GET a un vídeo que no existeix
        $response = $this->get(route('videos.show', 9999)); // Un ID que no existeix

        // Comprovar que la resposta retorna un error 404
        $response->assertStatus(404);
    }
}
