<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use App\Models\Noticia;

class VerNoticiaPanelController extends Controller
{
    public function __invoke($id)
    {
        $noticia = Noticia::with(['categorias', 'autor', 'medios'])->findOrFail($id);
        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        return view('admin.noticias.ver', compact('noticia', 'categorias'));
    }
}
