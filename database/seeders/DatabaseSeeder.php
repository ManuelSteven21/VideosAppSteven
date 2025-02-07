<?php

namespace Database\Seeders;

use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔥 Resetear caché de permisos para evitar problemas
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        UserHelper::createPermissions();

        // Crear el usuario por defecto
        UserHelper::createDefaultUser();

        // Crear el profesor por defecto
        UserHelper::createDefaultTeacher();

        // Crear el video por defecto
        VideoHelper::createDefaultVideos();

        // Crear els usuaris per defecte
        UserHelper::createSuperAdminUser();
        UserHelper::createRegularUser();
        UserHelper::createVideoManagerUser();
    }
}
