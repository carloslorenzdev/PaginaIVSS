<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;

class CrearCategoriaViewController extends Controller
{
    public function __invoke()
    {
        if (!auth()->user()->hasAnyRole(['admin'])) {
            abort(403, 'No tienes permiso para crear categorias.');
        }

        return view('admin.categorias.crear');
    }
}
