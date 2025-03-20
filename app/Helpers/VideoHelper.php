<?php

namespace App\Helpers;

use App\Models\Video;

class VideoHelper
{

    public static function createDefaultVideos()
    {
        $videos = [];

        $videos[] = Video::create([
            'title' => config('videos.video_1.title'),
            'description' => config('videos.video_1.description'),
            'url' => config('videos.video_1.url'),
            'previous' => config('videos.video_1.previous'),
            'next' => config('videos.video_1.next'),
            'series_id' => 1, // Valor asignado manualmente
            'published_at' => now(), // Fecha actual
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_2.title'),
            'description' => config('videos.video_2.description'),
            'url' => config('videos.video_2.url'),
            'previous' => config('videos.video_2.previous'),
            'next' => config('videos.video_2.next'),
            'series_id' => 1,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_3.title'),
            'description' => config('videos.video_3.description'),
            'url' => config('videos.video_3.url'),
            'previous' => config('videos.video_3.previous'),
            'next' => config('videos.video_3.next'),
            'series_id' => 1,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_4.title'),
            'description' => config('videos.video_4.description'),
            'url' => config('videos.video_4.url'),
            'previous' => config('videos.video_4.previous'),
            'next' => config('videos.video_4.next'),
            'series_id' => 1,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_5.title'),
            'description' => config('videos.video_5.description'),
            'url' => config('videos.video_5.url'),
            'previous' => config('videos.video_5.previous'),
            'next' => config('videos.video_5.next'),
            'series_id' => 1,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        // Agrega más videos según sea necesario...

        return collect($videos); // Devuelve una colección de videos
    }
}
