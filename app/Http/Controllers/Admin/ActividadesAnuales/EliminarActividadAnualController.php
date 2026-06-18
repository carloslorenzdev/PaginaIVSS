<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use App\Actions\Admin\ActividadesAnuales\EliminarActividadAnualAction;

class EliminarActividadAnualController extends Controller
{
    public function __invoke($id, EliminarActividadAnualAction $action)
    {
        $action->execute($id);

        return redirect()->route('admin.actividades')->with('success', 'Actividad eliminada correctamente.');
    }
}
