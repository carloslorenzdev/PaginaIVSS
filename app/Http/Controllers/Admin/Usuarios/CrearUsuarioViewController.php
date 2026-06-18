<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;

class CrearUsuarioViewController extends Controller
{
    public function __invoke()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('admin.usuarios.crear');
    }
}
