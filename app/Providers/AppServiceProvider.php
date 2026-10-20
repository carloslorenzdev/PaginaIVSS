<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        \Illuminate\Support\Facades\Vite::usePreloadTagAttributes(function (string $src, string $url, ?array $chunk, ?array $manifest) {
            if (str_ends_with($url, '.css')) {
                return false;
            }
            return [];
        });
    }
}
