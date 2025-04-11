<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Series; // ✅ AÑADIR ESTO
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'url' => 'https://www.youtube.com/embed/' . $this->faker->uuid,
            'series_id' => Series::factory(), // Crear serie automáticamente
            'user_id' => User::factory(), // Crear usuario automáticamente
            'published_at' => now(),
        ];
    }
}
