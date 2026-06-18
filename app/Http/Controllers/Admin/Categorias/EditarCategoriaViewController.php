<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class EditarCategoriaViewController extends Controller
{
    public function __invoke($id)
    {
        if (!auth()->user()->hasAnyRole(['admin'])) {
            abort(403, 'No tienes permiso para editar categorias.');
        }

        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.editar', compact('categoria'));
    }
}
