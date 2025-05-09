<?php

namespace Database\Seeders;

use App\Helpers\SerieHelper;
use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
use App\Models\Series;
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
        // Crear permisos y roles
        UserHelper::createPermissions();

        // Crear usuarios y asignar roles
        UserHelper::createDefaultUser();
        UserHelper::createDefaultTeacher();
        UserHelper::createRegularUser();
        UserHelper::createVideoManagerUser();
        UserHelper::createSuperAdminUser();
        SerieHelper::createDefaultSeries();
        VideoHelper::createDefaultVideos();
    }
}
