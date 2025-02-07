<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class UserHelper
{
    public static function addPersonalTeam(User $user)
    {
        // Crear l'equip personal per a l'usuari
        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        // Assignar l'equip a l'usuari
        $user->update(['current_team_id' => $team->id]);

        // Ens assegurem que el team_id es passi a model_has_roles.
        // Això ajuda a resoldre l'error de "NOT NULL constraint failed"
        $user->teams()->attach($team->id);

        return $team; // Retornem l'equip creat per si volem fer més operacions després
    }
    public static function defineGates()
    {
        Gate::define('manage-videos', function (User $user) {
            return $user->hasPermissionTo('manage videos');
        });

        Gate::define('manage-users', function (User $user) {
            return $user->hasPermissionTo('manage users');
        });

        Gate::define('manage-teams', function (User $user) {
            return $user->hasPermissionTo('manage teams');
        });

        Gate::define('manage-permissions', function (User $user) {
            return $user->isSuperAdmin(); // Només el superadmin pot gestionar permisos
        });
    }

    public static function createPermissions()
    {
        // Crear permisos
        $permissions = [
            'manage videos',
            'manage users',
            'manage teams',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear rols
        $roles = [
            'regular' => ['manage videos'],
            'video_manager' => ['manage videos', 'manage users'],
            'super_admin' => ['manage videos', 'manage users', 'manage teams', 'manage permissions'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            // Crear el rol si no existeix
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assignar permisos al rol
            $role->syncPermissions($rolePermissions);
        }
    }

//    public static function createDefaultUser()
//    {
//        // Crear l'usuari per defecte
//        $user = User::create([
//            'name' => config('users.default_user.name'),
//            'email' => config('users.default_user.email'),
//            'password' => Hash::make(config('users.default_user.password')),
//        ]);
//
//        // Afegir equip personal
//        $team = self::addPersonalTeam($user);
//
//        // Assignar el rol amb el team_id
//        $user->assignRole('regular', $team->id);
//
//        return $user;
//    }

    public static function createDefaultUser()
    {
        $user = User::create([
            'name' => config('users.default_user.name'),
            'email' => config('users.default_user.email'),
            'password' => Hash::make(config('users.default_user.password')),
        ]);

        // Crear equipo personal y asignarlo al usuario
        $team = self::addPersonalTeam($user);

        // ⚠️ Establecer el contexto de equipo ANTES de asignar roles
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        // 🛠️ Asegurar que el rol existe antes de asignarlo
        $role = Role::where('name', 'regular')->first();
        if ($role) {
            $user->assignRole($role);
        } else {
            throw new \Exception("El rol 'regular' no existe en la base de datos.");
        }

        return $user;
    }

    public static function createDefaultTeacher()
    {
        // Crear el usuario
        $teacher = User::create([
            'name' => config('users.default_teacher.name'),
            'email' => config('users.default_teacher.email'),
            'password' => Hash::make(config('users.default_teacher.password')),
            'super_admin' => true, // Li donem permisos de superadmin
        ]);

        $team = self::addPersonalTeam($teacher); // Ara utilitzem la funció reutilitzable
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($team->id);
        // 🛠️ Asegurar que el rol existe antes de asignarlo
        $role = Role::where('name', 'super_admin')->first();
        if ($role) {
            $teacher->assignRole($role);
        } else {
            throw new \Exception("El rol 'regular' no existe en la base de datos.");
        }

        return $teacher;
    }

    public static function createRegularUser()
    {
        $user = User::create([
            'name' => 'Regular',
            'email' => 'regular@videosapp.com',
            'password' => Hash::make('123456789'),
        ]);

        $team = self::addPersonalTeam($user);
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($team->id);
        // 🛠️ Asegurar que el rol existe antes de asignarlo
        $role = Role::where('name', 'regular')->first();
        if ($role) {
            $user->assignRole($role);
        } else {
            throw new \Exception("El rol 'regular' no existe en la base de datos.");
        }

        return $user;
    }

    public static function createVideoManagerUser()
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => Hash::make('123456789'),
        ]);

        $team = self::addPersonalTeam($user);
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($team->id);
        $role = Role::where('name', 'video_manager')->first();
        if ($role) {
            $user->assignRole($role);
        } else {
            throw new \Exception("El rol 'regular' no existe en la base de datos.");
        }


        return $user;
    }

    public static function createSuperAdminUser()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => true, // Assegurem que és superadmin
        ]);

        $team = self::addPersonalTeam($user);
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($team->id);
        $role = Role::where('name', 'super_admin')->first();
        if ($role) {
            $user->assignRole($role);
        } else {
            throw new \Exception("El rol 'regular' no existe en la base de datos.");
        }

        return $user;
    }
}
