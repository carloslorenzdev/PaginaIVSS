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
            // Permitir que las Policies evalúen restricciones críticas (ej: auto-eliminación o auto-bloqueo de usuarios)
            if (in_array($ability, ['banunban', 'delete', 'destroy'])) {
                return null;
            }
            return $user->hasRole('admin') ? true : null;
        });

        // Rate Limiter estricto para recuperación de contraseñas por IP y por cuenta (CWE-307)
        \Illuminate\Support\Facades\RateLimiter::for('password-reset', function (\Illuminate\Http\Request $request) {
            $usuario = \Illuminate\Support\Str::lower((string) $request->input('usuario', ''));
            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip()),
                \Illuminate\Cache\RateLimiting\Limit::perMinutes(15, 5)->by('reset|' . $usuario)->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Demasiados intentos de recuperación para esta cuenta. Por favor espere unos minutos antes de reintentar.'
                    ], 429);
                }),
            ];
        });

        \Illuminate\Support\Facades\Vite::usePreloadTagAttributes(function (string $src, string $url, ?array $chunk, ?array $manifest) {
            if (str_ends_with($url, '.css')) {
                return false;
            }
            return [];
        });
    }
}
