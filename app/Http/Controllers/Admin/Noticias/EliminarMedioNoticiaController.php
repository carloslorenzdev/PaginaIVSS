<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Noticias\EliminarMedioNoticiaAction;

class EliminarMedioNoticiaController extends Controller
{
    public function __invoke(Request $request, $noticiaId, $medioId, EliminarMedioNoticiaAction $action)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'redactor', 'aprobador']), 403, 'No tienes permiso para eliminar medios.');

        $action->execute($noticiaId, $medioId);

        return back()->with('success', 'Medio eliminado exitosamente.');
    }
}
