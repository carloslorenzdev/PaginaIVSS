<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Actions\Admin\Usuarios\ToggleEstadoUsuarioAction;

class ToggleEstadoUsuarioController extends Controller
{
    public function __invoke($id, ToggleEstadoUsuarioAction $action)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

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
