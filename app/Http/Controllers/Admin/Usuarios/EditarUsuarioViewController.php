<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;

class EditarUsuarioViewController extends Controller
{
    public function __invoke($id)
    {
        abort_if(!auth()->user()->can('usuarios.editar'), 403, 'Acceso denegado: No tienes permiso para editar usuarios.');

        $usuario = User::findOrFail($id);

        return view('admin.usuarios.editar', compact('usuario'));
    }
}
