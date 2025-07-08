<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        // TODOS los usuarios autenticados pueden hacer todo
        Gate::define('aprobar_permisos', function ($user) {
            return true; // Cualquier usuario autenticado
        });

        Gate::define('control_seguridad', function ($user) {
            return true; // Cualquier usuario autenticado
        });

        Gate::define('ver_todos_permisos', function ($user) {
            return true; // Cualquier usuario autenticado
        });

        Gate::define('delete_permisos', function ($user) {
            return true; // Cualquier usuario autenticado
        });
    }
}
