<?php

namespace Database\Seeders;

use App\Helpers\UserHelper;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        // Crear el usuario por defecto
        UserHelper::createDefaultUser();

        // Crear el profesor por defecto
        UserHelper::createDefaultTeacher();
    }
}
