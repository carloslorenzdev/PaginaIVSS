<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;

class EditarUsuarioViewController extends Controller
{
    public function __invoke($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $usuario = User::findOrFail($id);

        return view('admin.usuarios.editar', compact('usuario'));
    }
}
