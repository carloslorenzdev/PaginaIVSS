<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verificar si la respuesta soporta agregar headers
        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('X-XSS-Protection', '1; mode=block');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->header('Permissions-Policy', 'geolocation=*, microphone=(), camera=()');
            
            // HSTS solo se debería aplicar si se está usando HTTPS en producción.
            // NOTA CRÍTICA: NO usar 'includeSubDomains' ni 'preload' porque los servicios legacy del IVSS
            // (Tiuna, Solvencias, Constancias en puertos 28080-28089) operan en subdominios bajo HTTP puro.
            // Con 'includeSubDomains', los navegadores forzaban automáticamente HTTPS en esos subdominios causando ERR_SSL_PROTOCOL_ERROR.
            if (config('app.env') === 'production' && $request->isSecure()) {
                $response->header('Strict-Transport-Security', 'max-age=31536000');
            }
        }

        return $response;
    }
}
