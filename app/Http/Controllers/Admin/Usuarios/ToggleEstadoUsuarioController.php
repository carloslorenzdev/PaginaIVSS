<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Actions\Admin\Usuarios\ToggleEstadoUsuarioAction;

class ToggleEstadoUsuarioController extends Controller
{
    public function __invoke($id, ToggleEstadoUsuarioAction $action)
    {
        abort_if(!auth()->user()->can('usuarios.toggle_estado'), 403, 'Acceso denegado: No tienes permiso para cambiar el estado de usuarios.');

        $usuario = User::findOrFail($id);

        try {
            $action->execute($usuario);
            $estado = $usuario->activo ? 'activado' : 'desactivado';
            return redirect()->route('admin.usuarios.index')->with('success', "Usuario {$estado} exitosamente.");
        } catch (\Exception $e) {
            return redirect()->route('admin.usuarios.index')->withErrors($e->getMessage());
        }
    }
}
