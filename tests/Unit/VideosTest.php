<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Video;
use App\Models\Series;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_formatted_published_at_date()
    {
        Carbon::setLocale('es');

        // 1. Crear la serie necesaria primero
        $series = Series::factory()->create();

        // 2. Crear el usuario
        $user = User::factory()->create();

        // 3. Crear el video asociado a ambos
        $video = Video::factory()->create([
            'series_id' => $series->id,
            'user_id' => $user->id,
            'published_at' => Carbon::parse('2025-01-17 14:00:00'),
        ]);

        $this->assertEquals('17 de enero de 2025', $video->formatted_published_at);
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        // 1. Crear la serie
        $series = Series::factory()->create();

        // 2. Crear el video sin fecha de publicación
        $video = Video::factory()->create([
            'series_id' => $series->id,
            'published_at' => null,
        ]);

        $this->assertNull($video->formatted_published_at);
    }
}
