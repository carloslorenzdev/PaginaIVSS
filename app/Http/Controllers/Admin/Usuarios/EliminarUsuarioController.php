<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Actions\Admin\Usuarios\EliminarUsuarioAction;

class EliminarUsuarioController extends Controller
{
    public function __invoke($id, EliminarUsuarioAction $action)
    {
        abort_if(!auth()->user()->can('usuarios.eliminar'), 403, 'Acceso denegado: No tienes permiso para eliminar usuarios.');

        $usuario = User::findOrFail($id);

        try {
            $action->execute($usuario);
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.usuarios.index')->withErrors($e->getMessage());
        }
    }
}
