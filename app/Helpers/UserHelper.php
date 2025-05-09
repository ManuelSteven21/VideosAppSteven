<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserHelper
{
    public static function createPermissions()
    {
        \Log::info('Current Database Connection: ' . DB::connection()->getDatabaseName());
        // Crear permisos
        $permissions = [
            'manage-videos',
            'manage-users',
            'create-videos',
            'manage-series',
            'create-series'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Limpiar caché de permisos
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Crear roles y asignar permisos
        $roles = [
            'regular' => [
                'create-videos', 'create-series'
            ],
            'video_manager' => [
                'manage-videos', 'create-videos',
                'manage-series', 'create-series'
            ],
            'super_admin' => [
                'manage-videos', 'manage-users',
                'create-videos', 'manage-series',
                'create-series'
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Limpiar caché de permisos nuevamente
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public static function defineGates()
    {
        Gate::define('manage-videos', function (User $user) {
            return $user->hasPermissionTo('manage-videos');
        });
        Gate::define('manage-users', function (User $user) {
            return $user->hasPermissionTo('manage-users');
        });
        Gate::define('manage-series', function (User $user) {
            return $user->hasPermissionTo('manage-series');
        });
        Gate::define('create-videos', function (User $user) {
            return $user->hasPermissionTo('create-videos');
        });
    }

    public static function assignRole(User $user, $roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            throw new \Exception("El rol '$roleName' no existe.");
        }

        // Asignar el rol al usuario
        $user->syncRoles([$role]);

        // Asignar permisos al usuario
        $permissions = $role->permissions;
        $user->syncPermissions($permissions);
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
        self::addPersonalTeam($user);

        // Establecer el contexto de equipo ANTES de asignar roles
        self::assignRole($user, 'regular');

        return $user;
    }

    public static function createDefaultTeacher()
    {
        // Crear el usuario
        $user = User::create([
            'name' => config('users.default_teacher.name'),
            'email' => config('users.default_teacher.email'),
            'password' => Hash::make(config('users.default_teacher.password')),
            'super_admin' => true, // Permisos de superadmin
        ]);

        self::addPersonalTeam($user);

        self::assignRole($user, 'super_admin');

        return $user;
    }

    public static function createRegularUser()
    {
        $user = User::create([
            'name' => 'Regular',
            'email' => 'regular@videosapp.com',
            'password' => Hash::make('123456789'),
        ]);

        self::addPersonalTeam($user);

        // Establecer el contexto de equipo ANTES de asignar roles
        self::assignRole($user, 'regular');

        return $user;
    }

    public static function createVideoManagerUser()
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => Hash::make('123456789'),
        ]);

        self::addPersonalTeam($user);

        self::assignRole($user, 'video_manager');

        return $user;
    }

    public static function createSuperAdminUser()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => true, // Asegurar que es superadmin
        ]);

        self::addPersonalTeam($user);

        self::assignRole($user, 'super_admin');

        return $user;
    }
}
