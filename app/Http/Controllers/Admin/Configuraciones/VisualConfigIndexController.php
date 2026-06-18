<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;

class VisualConfigIndexController extends Controller
{
    public function __invoke()
    {


        $configuraciones = Configuracion::pluck('valor', 'clave')->toArray();

        return view('admin.configuraciones.visual', compact('configuraciones'));
    }
}
