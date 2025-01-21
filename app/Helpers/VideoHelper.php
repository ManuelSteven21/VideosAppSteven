<?php

namespace App\Helpers;

use App\Models\Video;

class VideoHelper
{
    public static function createDefaultVideo()
    {
        return Video::create([
            'title' => config('videos.default_video.title'),
            'description' => config('videos.default_video.description'),
            'url' => config('videos.default_video.url'),
            'previous' => config('videos.default_video.previous'),
            'next' => config('videos.default_video.next'),
            'series_id' => 1, // Valor asignado manualmente
            'published_at' => now(), // Fecha actual
        ]);
    }
}
