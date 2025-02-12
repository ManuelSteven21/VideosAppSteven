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
    public static function createPermissions()
    {
        // Crear permisos
        $permissions = [
            'manage videos',
            'view videos', // Permiso para ver videos
            'manage users',
            'manage teams',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $roles = [
            'regular' => ['view videos'], // El rol 'regular' debe tener permiso para ver videos
            'video_manager' => ['manage videos', 'view videos'],
            'super_admin' => ['manage videos', 'manage users', 'manage teams', 'manage permissions', 'view videos'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            // Crear el rol si no existe
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Asignar permisos al rol
            $role->syncPermissions($rolePermissions);
        }
    }

    public static function defineGates()
    {
        Gate::define('view-videos', function (User $user) {
            return $user->hasPermissionTo('view videos');
        });
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
            return $user->isSuperAdmin();
        });
    }

    public static function assignRoleWithTeam(User $user, $roleName, $teamId)
    {
        // Verificar si el rol existe
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            throw new \Exception("El rol '$roleName' no existe.");
        }

        // Asignar el rol al usuario
        $user->assignRole($role);

        // Actualizar el team_id en la tabla model_has_roles
        \DB::table('model_has_roles')
            ->where('role_id', $role->id)
            ->where('model_id', $user->id)
            ->update(['current_team_id' => $teamId]);
    }

    public static function addPersonalTeam(User $user)
    {
        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $user->update(['current_team_id' => $team->id]);
        $user->teams()->attach($team->id);

        return $team;
    }

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
        self::assignRoleWithTeam($user, 'regular', $team->id);


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
        self::assignRoleWithTeam($teacher, 'super_admin', $team->id);

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
        self::assignRoleWithTeam($user, 'regular', $team->id);

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
        self::assignRoleWithTeam($user, 'video_manager', $team->id);


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
        self::assignRoleWithTeam($user, 'super_admin', $team->id);


        return $user;
    }
}
