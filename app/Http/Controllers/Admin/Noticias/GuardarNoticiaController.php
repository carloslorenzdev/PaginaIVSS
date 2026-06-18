<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Noticias\CrearNoticiaAction;

class GuardarNoticiaController extends Controller
{
    public function __invoke(Request $request, CrearNoticiaAction $action)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'redactor']), 403, 'No tienes permiso para guardar noticias.');

        $request->validate([
            'titulo' => 'required|max:255',
            'resumen' => 'required',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:categorias,id',
            'archivo' => 'required|image|max:51200',
            'leyenda' => 'nullable|string|max:500',
            'contenido' => 'nullable',
            'enlace_externo' => 'nullable|url|max:500',
            'etiquetas' => 'nullable|string|max:500',
            'creditos_autor' => 'required|string|max:255',
        ]);

        $action->execute(
            $request->only(['titulo', 'resumen', 'categorias', 'contenido', 'enlace_externo', 'etiquetas', 'creditos_autor', 'leyenda']),
            $request->file('archivo'),
            auth()->id()
        );

        return redirect()->route('admin.panel')->with('success', 'Noticia creada exitosamente con su imagen principal. Ahora está como borrador.');
    }
}
