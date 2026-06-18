<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Actions\Admin\Usuarios\EliminarUsuarioAction;

class EliminarUsuarioController extends Controller
{
    public function __invoke($id, EliminarUsuarioAction $action)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $usuario = User::findOrFail($id);

        try {
            $action->execute($usuario);
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.usuarios.index')->withErrors($e->getMessage());
        }
    }
}
