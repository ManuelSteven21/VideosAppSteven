<?php

namespace Database\Factories;

use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition()
    {
        // Obtenemos un usuario fijo para asociarlo a la serie
        $user = User::find(5); // Puedes hacer esto si el usuario con ID 5 ya existe o crear uno nuevo

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl,
            'user_name' => $user ? $user->name : 'Super Admin',
            'user_photo_url' => $user ? $user->profile_photo_url : 'https://www.example.com/photo.jpg',
            'published_at' => now(),
        ];
    }
}
