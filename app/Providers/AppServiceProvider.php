<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Helpers\UserHelper;
use App\Models\User;
use App\Policies\UserPolicy;
use Spatie\Permission\Models\Permission;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Registrar les polítiques d'autorització
        Gate::policy(User::class, UserPolicy::class);

        // Definir les portes d'accés (Gates)
        UserHelper::defineGates();
    }
}
