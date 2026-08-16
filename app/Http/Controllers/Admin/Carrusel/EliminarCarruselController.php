<?php

namespace App\Http\Controllers\Admin\Carrusel;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Carrusel\EliminarCarruselAction;

class EliminarCarruselController extends Controller
{
    public function __invoke($id, EliminarCarruselAction $action)
    {
        abort_if(!auth()->user()->can('carrusel.eliminar'), 403, 'No tienes permiso para eliminar carrusel.');
        $action->execute($id);

        return redirect()->back()->with('success', 'Imagen eliminada del carrusel exitosamente.');
    }
}
