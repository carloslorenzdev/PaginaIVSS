<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use App\Actions\Admin\ActividadesAnuales\EliminarMedioActividadAction;

class EliminarMedioActividadController extends Controller
{
    public function __invoke($actividadId, $medioId, EliminarMedioActividadAction $action)
    {
        $action->execute($actividadId, $medioId);

        return back()->with('success', 'Medio eliminado exitosamente.');
    }
}
