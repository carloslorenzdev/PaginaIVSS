<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use App\Models\Noticia;

class VerNoticiaPanelController extends Controller
{
    public function __invoke($id)
    {
        abort_if(!auth()->user()->can('noticias.ver'), 403, 'No tienes permiso para ver noticias.');
        $noticia = Noticia::with(['categorias', 'autor', 'medios'])->findOrFail($id);
        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        return view('admin.noticias.ver', compact('noticia', 'categorias'));
    }
}
