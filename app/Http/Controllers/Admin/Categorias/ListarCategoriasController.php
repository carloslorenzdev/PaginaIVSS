<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class ListarCategoriasController extends Controller
{
    public function __invoke()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'redactor', 'aprobador'])) {
            abort(403, 'No tienes permiso para ver categorias.');
        }

        $categorias = Categoria::orderBy('orden')->get();
        return view('admin.categorias.index', compact('categorias'));
    }
}
