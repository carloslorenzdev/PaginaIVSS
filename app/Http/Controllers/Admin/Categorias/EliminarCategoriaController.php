<?php

namespace App\Http\Controllers\Admin\Categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class EliminarCategoriaController extends Controller
{
    public function __invoke($id)
    {
        if (!auth()->user()->can('categorias.eliminar')) {
            abort(403, 'No tienes permiso para eliminar categorias.');
        }

        $categoria = Categoria::findOrFail($id);
        
        // Comprobar si tiene noticias asociadas antes de eliminar
        if ($categoria->noticias()->count() > 0) {
            return back()->with('error', 'No puedes eliminar una categoría que tiene noticias asociadas.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
