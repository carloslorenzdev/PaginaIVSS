<?php

namespace App\Actions\Admin\Usuarios;

use App\Models\User;

class EliminarUsuarioAction
{
    public function execute(User $usuario)
    {
        // En un caso real podríamos verificar dependencias aquí antes de eliminar.
        // O reasignar las noticias y actividades a otro usuario, o evitar borrar el último admin.
        
        if ($usuario->rol === 'admin' && User::where('rol', 'admin')->count() <= 1) {
            throw new \Exception('No puedes eliminar al último administrador del sistema.');
        }

        if (auth()->id() === $usuario->id) {
            throw new \Exception('No puedes eliminar tu propio usuario mientras estás en sesión.');
        }

        return $usuario->delete();
    }
}
