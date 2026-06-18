<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSolicitudIsPending
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->solicitud->estatus->isPendiente()) {
            return to_route('solicitudes.detalle', $request->solicitud)->withAlert([
                'danger',
                'Solicitud debe tener estatus PENDIENTE'
            ]);
        }
        return $next($request);
    }
}
