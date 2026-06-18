<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SeguridadUsuarioController extends Controller
{
    /**
     * Bloquea usuario
     */
    public function bloquear(Request $request, User $usuario): RedirectResponse
    {
        $this->authorize('banunban', $usuario);

        if ($usuario->isActivo()) {
            $usuario->bloqueado = now();

            if ($usuario->isDirty()) {
                $usuario->updated_by = $request->user()->id;
                $usuario->save();
                Log::channel('acciones')
                    ->warning('El usuario "' . $request->user()->usuario . '" ha bloqueado a "' . $usuario->usuario . '"');
            }
        }

        return back()->withAlert([
            'success',
            [
                'mensaje' => 'Usuario Bloqueado',
                'ayuda' => $usuario->usuario . " ha sido bloqueado"
            ]
        ]);
    }

    /**
     * Desbloquear usuario
     */
    public function desbloquear(Request $request, User $usuario): RedirectResponse
    {
        $this->authorize('banunban', $usuario);

        if ($usuario->isBloqueado()) {
            $usuario->bloqueado = null;

            if ($usuario->isDirty()) {
                $usuario->updated_by = $request->user()->id;
                $usuario->save();
                Log::channel('acciones')
                    ->warning('El usuario "' . $request->user()->usuario . '" ha desbloqueado a "' . $usuario->usuario . '"');
            }
        }

        return back()->withAlert([
            'success',
            [
                'mensaje' => 'Usuario Desbloqueado',
                'ayuda' => $usuario->usuario . " ha sido desbloqueado"
            ]
        ]);
    }

    /**
     * Restablecer contraseña
     */
    public function restablecer(Request $request, User $usuario): RedirectResponse
    {
        $this->authorize('banunban', $usuario);

        $usuario->cambio_pass = null;
        $usuario->password = Hash::make($usuario->usuario);

        if ($usuario->isDirty()) {
            $usuario->updated_by = $request->user()->id;
            $usuario->save();
            Log::channel('acciones')
                ->warning('El usuario "' . $request->user()->usuario . '" ha restablecido la contraseña a "' . $usuario->usuario . '"');
        }

        return back()->withAlert([
            'success',
            [
                'mensaje' => 'Contraseña restablecida',
                'ayuda' => "$usuario->usuario se reestableció su contraseña"
            ]
        ]);
    }
}
