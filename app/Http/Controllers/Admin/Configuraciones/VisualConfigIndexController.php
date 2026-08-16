<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;

class VisualConfigIndexController extends Controller
{
    public function __invoke()
    {
        abort_if(!auth()->user()->can('configuracion.ver'), 403, 'No tienes permiso para ver la configuración.');


        $configuraciones = Configuracion::pluck('valor', 'clave')->toArray();

        return view('admin.configuraciones.visual', compact('configuraciones'));
    }
}
