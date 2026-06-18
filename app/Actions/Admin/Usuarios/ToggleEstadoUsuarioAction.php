<?php

namespace App\Actions\Admin\Usuarios;

use App\Models\User;

class ToggleEstadoUsuarioAction
{
    public function execute(User $usuario)
    {
        if ($usuario->rol === 'admin' && User::where('rol', 'admin')->where('activo', true)->count() <= 1 && $usuario->activo) {
            throw new \Exception('No puedes desactivar al último administrador activo del sistema.');
        }

        if (auth()->id() === $usuario->id) {
            throw new \Exception('No puedes desactivar tu propio usuario mientras estás en sesión.');
        }

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return $usuario;
    }
}
