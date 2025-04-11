<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Series;
use App\Models\Video;
use PHPUnit\Framework\Attributes\Test;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function serie_have_videos()
    {
        // Creamos una serie
        $serie = Series::factory()->create();

        // Creamos dos videos asociados a la serie
        $video1 = Video::factory()->create(['series_id' => $serie->id]);
        $video2 = Video::factory()->create(['series_id' => $serie->id]);

        // Refrescamos la relación por si acaso
        $serie->load('videos');

        // Afirmamos que la serie tiene 2 videos
        $this->assertCount(2, $serie->videos);

        // Verificamos que los videos estén en la colección de la serie
        $this->assertTrue($serie->videos->contains($video1));
        $this->assertTrue($serie->videos->contains($video2));
    }
}
