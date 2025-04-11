<?php

namespace App\Helpers;

use App\Models\Video;
use App\Models\Series;


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

        $videos[] = Video::create([
            'title' => config('videos.video_6.title'),
            'description' => config('videos.video_6.description'),
            'url' => config('videos.video_6.url'),
            'previous' => config('videos.video_6.previous'),
            'next' => config('videos.video_6.next'),
            'series_id' => 2,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_7.title'),
            'description' => config('videos.video_7.description'),
            'url' => config('videos.video_7.url'),
            'previous' => config('videos.video_7.previous'),
            'next' => config('videos.video_7.next'),
            'series_id' => 2,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_8.title'),
            'description' => config('videos.video_8.description'),
            'url' => config('videos.video_8.url'),
            'previous' => config('videos.video_8.previous'),
            'next' => config('videos.video_8.next'),
            'series_id' => 2,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_9.title'),
            'description' => config('videos.video_9.description'),
            'url' => config('videos.video_9.url'),
            'previous' => config('videos.video_9.previous'),
            'next' => config('videos.video_9.next'),
            'series_id' => 3,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_10.title'),
            'description' => config('videos.video_10.description'),
            'url' => config('videos.video_10.url'),
            'previous' => config('videos.video_10.previous'),
            'next' => config('videos.video_10.next'),
            'series_id' => 3,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_11.title'),
            'description' => config('videos.video_11.description'),
            'url' => config('videos.video_11.url'),
            'previous' => config('videos.video_11.previous'),
            'next' => config('videos.video_11.next'),
            'series_id' => 3,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        $videos[] = Video::create([
            'title' => config('videos.video_12.title'),
            'description' => config('videos.video_12.description'),
            'url' => config('videos.video_12.url'),
            'previous' => config('videos.video_12.previous'),
            'next' => config('videos.video_12.next'),
            'series_id' => 3,
            'published_at' => now(),
            'user_id' => 5, // usuari administrador de videos
        ]);

        // Agrega más videos según sea necesario...

        return collect($videos); // Devuelve una colección de videos
    }
}
