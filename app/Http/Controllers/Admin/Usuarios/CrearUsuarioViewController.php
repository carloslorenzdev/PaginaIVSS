<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;

class CrearUsuarioViewController extends Controller
{
    public function __invoke()
    {
        abort_if(!auth()->user()->can('usuarios.crear'), 403, 'Acceso denegado: No tienes permiso para crear usuarios.');

        return view('admin.usuarios.crear');
    }
}
