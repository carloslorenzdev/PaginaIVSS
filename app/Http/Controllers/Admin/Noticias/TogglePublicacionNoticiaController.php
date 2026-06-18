<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Noticias\TogglePublicacionNoticiaAction;

class TogglePublicacionNoticiaController extends Controller
{
    public function __invoke(Request $request, $id, TogglePublicacionNoticiaAction $action)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'aprobador']), 403, 'No tienes permiso para publicar o despublicar noticias.');

        $noticia = $action->execute($id, $request->only(['fecha_programada', 'montar_carrusel']));

        $estado = $noticia->publicado ? 'publicada' : 'despublicada';
        return back()->with('success', "Noticia {$estado} correctamente.");
    }
}
