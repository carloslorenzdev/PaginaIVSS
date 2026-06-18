<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;

class CrearActividadAnualViewController extends Controller
{
    public function __invoke()
    {
        return view('admin.actividades.crear');
    }
}
