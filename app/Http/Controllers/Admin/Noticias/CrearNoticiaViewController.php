<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class CrearNoticiaViewController extends Controller
{
    public function __invoke()
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'redactor']), 403, 'No tienes permiso para crear noticias.');

        $categorias = Categoria::where('activa', true)->get();
        return view('admin.noticias.crear', compact('categorias'));
    }
}
