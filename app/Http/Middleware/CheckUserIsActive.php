<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->usuario;
        if ($usuario->isBloqueado()) {
            return to_route('usuarios.detalle', $usuario)->withAlert([
                'danger',
                [
                    'mensaje' => 'Usuario Bloqueado',
                    'ayuda' => 'Para poder editar a ' . $usuario->usuario . ', debe tener estatus activo'
                ]
            ]);
        }
        return $next($request);
    }
}
