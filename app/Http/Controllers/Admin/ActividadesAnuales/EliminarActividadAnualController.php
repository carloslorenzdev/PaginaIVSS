<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use App\Actions\Admin\ActividadesAnuales\EliminarActividadAnualAction;

class EliminarActividadAnualController extends Controller
{
    public function __invoke($id, EliminarActividadAnualAction $action)
    {
        abort_if(!auth()->user()->can('actividades.eliminar'), 403, 'No tienes permiso para eliminar actividades.');
        $action->execute($id);

        return redirect()->route('admin.actividades')->with('success', 'Actividad eliminada correctamente.');
    }
}
