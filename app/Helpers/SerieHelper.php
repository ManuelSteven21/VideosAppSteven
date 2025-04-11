<?php

namespace App\Helpers;

use App\Models\Series;

class SerieHelper
{
    public static function createDefaultSeries()
    {
        $series = [];

        // Crear 3 series con los campos necesarios
        $series[] = Series::create([
            'title' => config('series.serie_1.title'),
            'description' => config('series.serie_1.description'),
            'image' => config('series.serie_1.image'),
            'user_name' => config('series.serie_1.user_name'),
            'user_photo_url' => config('series.serie_1.user_photo_url'),
            'published_at' => now(),
        ]);

        $series[] = Series::create([
            'title' => config('series.serie_2.title'),
            'description' => config('series.serie_2.description'),
            'image' => config('series.serie_2.image'),
            'user_name' => config('series.serie_2.user_name'),
            'user_photo_url' => config('series.serie_2.user_photo_url'),
            'published_at' => now(),
        ]);

        $series[] = Series::create([
            'title' => config('series.serie_3.title'),
            'description' => config('series.serie_3.description'),
            'image' => config('series.serie_3.image'),
            'user_name' => config('series.serie_3.user_name'),
            'user_photo_url' => config('series.serie_3.user_photo_url'),
            'published_at' => now(),
        ]);

        return collect($series);
    }
}
