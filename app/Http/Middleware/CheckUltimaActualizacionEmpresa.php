<?php

namespace App\Http\Middleware;

use App\Models\Empresa\ActualizacionEmpresa;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUltimaActualizacionEmpresa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->isPatrono()) {
            /** @var User */
            $user = $request->user();
            $ultActualizacion = ActualizacionEmpresa::where('fk_empresa', $user->usuario)->first();
            if (!$ultActualizacion || $ultActualizacion->isExpirada()) {
                return to_route('empresa.actualizacion')->withAlert(['info', [
                    'mensaje' => 'Actualización Requerida',
                    'ayuda' => 'Necesitamos que actualices la información de tu empresa',
                ]]);
            }
        }
        return $next($request);
    }
}
