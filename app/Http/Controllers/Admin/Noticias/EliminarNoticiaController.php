<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Noticias\EliminarNoticiaAction;

class EliminarNoticiaController extends Controller
{
    public function __invoke($id, EliminarNoticiaAction $action)
    {
        abort_if(!auth()->user()->can('noticias.eliminar'), 403, 'No tienes permiso para eliminar noticias.');

        $action->execute($id);

        return redirect()->route('admin.panel')->with('success', 'Noticia eliminada correctamente.');
    }
}
