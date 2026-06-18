<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Valida que el usuario tenga algún metodo 2FA habilitado
 */
class EnsureUserHasAnyTwoFactorEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->hasEnabled2fa()) {
            return back()->withAlert(['danger', [
                'mensaje' => '2FA deshabilitado',
                'ayuda' => 'Debes tener algún método de autenticación de dos factores activo',
                'acciones' => [
                    [
                        'descripcion' => 'Activar',
                        'ruta' => route('perfil.2fa.informacion'),
                    ]
                ]
            ]]);
        }
        return $next($request);
    }
}
