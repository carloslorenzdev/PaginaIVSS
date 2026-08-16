<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use App\Models\ActividadAnual;

class VerActividadAnualController extends Controller
{
    public function __invoke($id)
    {
        abort_if(!auth()->user()->can('actividades.ver'), 403, 'No tienes permiso para ver actividades.');
        $actividad = ActividadAnual::with(['autor', 'medios' => function($q) {
            $q->orderBy('actividad_anual_medios.orden', 'asc');
        }])->findOrFail($id);
        
        return view('admin.actividades.ver', compact('actividad'));
    }
}
