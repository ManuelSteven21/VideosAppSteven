<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine si l'usuari pot veure altres usuaris.
     */
    public function view(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id || $authUser->hasPermissionTo('manage users') || $authUser->isSuperAdmin();
    }

    /**
     * Determine si l'usuari pot gestionar altres usuaris.
     */
    public function manage(User $authUser): bool
    {
        return $authUser->hasPermissionTo('manage users') || $authUser->isSuperAdmin();
    }

    /**
     * Determine si l'usuari pot gestionar vídeos.
     */
    public function manageVideos(User $authUser): bool
    {
        return $authUser->hasPermissionTo('manage videos') || $authUser->isSuperAdmin();
    }

    /**
     * Determine si l'usuari pot veure vídeos.
     */
    public function viewVideos(User $authUser): bool
    {
        return $authUser->hasPermissionTo('view videos');
    }

    /**
     * Determine si l'usuari pot gestionar equips.
     */
    public function manageTeams(User $authUser): bool
    {
        return $authUser->hasPermissionTo('manage teams') || $authUser->isSuperAdmin();
    }

    /**
     * Determine si l'usuari pot gestionar permisos.
     */
    public function managePermissions(User $authUser): bool
    {
        return $authUser->isSuperAdmin();
    }
}
