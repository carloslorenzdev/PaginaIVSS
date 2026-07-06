<?php

namespace App\Providers;

use App\Models\Solicitudes\Solicitud;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\Solicitudes\SolicitudPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PoliciesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            $policies = [
                User::class => UserPolicy::class,
                Solicitud::class => SolicitudPolicy::class,
            ];
            if (array_key_exists($modelClass, $policies)) {
                return $policies[$modelClass];
            }
        });
    }
}
