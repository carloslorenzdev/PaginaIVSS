<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;

class CrearActividadAnualViewController extends Controller
{
    public function __invoke()
    {
        abort_if(!auth()->user()->can('actividades.crear'), 403, 'No tienes permiso para crear actividades.');
        return view('admin.actividades.crear');
    }
}
