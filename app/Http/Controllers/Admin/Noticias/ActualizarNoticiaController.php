<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Actions\Admin\Noticias\ActualizarNoticiaAction;

class ActualizarNoticiaController extends Controller
{
    public function __invoke(Request $request, Noticia $noticia, ActualizarNoticiaAction $action)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'redactor']), 403, 'No tienes permiso para editar noticias.');

        $request->validate([
            'titulo' => 'required|max:255',
            'resumen' => 'required',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:categorias,id',
            'archivo' => 'nullable|image|max:51200',
            'leyenda' => 'nullable|string|max:500',
            'contenido' => 'nullable',
            'enlace_externo' => 'nullable|url|max:500',
            'etiquetas' => 'nullable|string|max:500',
            'creditos_autor' => 'required|string|max:255',
        ]);

        $action->execute(
            $noticia,
            $request->only(['titulo', 'resumen', 'categorias', 'contenido', 'enlace_externo', 'etiquetas', 'creditos_autor', 'leyenda', 'eliminar_imagen']),
            $request->file('archivo'),
            auth()->id()
        );

        // Si se envió leyenda, actualizamos la leyenda de la imagen principal
        if ($request->has('leyenda')) {
            $imagenPrincipal = $noticia->medios()->wherePivot('tipo_relacion', 'principal')->first();
            if ($imagenPrincipal) {
                $imagenPrincipal->update(['leyenda' => $request->leyenda]);
            }
        }

        return redirect()->route('admin.noticias.ver', $noticia->id)->with('success', 'Noticia actualizada exitosamente.');
    }
}
