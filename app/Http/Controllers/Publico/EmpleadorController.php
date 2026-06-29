<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmpleadorController extends Controller
{
    public function informacionGeneral()
    {
        return view('publico.empleadores.informacion_general');
    }

    public function quienEs()
    {
        return view('publico.empleadores.quien_es');
    }

    public function tiposEmpresas()
    {
        return view('publico.empleadores.tipos_empresas');
    }

    public function sistemaAutoliquidacion()
    {
        return view('publico.empleadores.sistema_autoliquidacion');
    }

    public function tramites()
    {
        return view('publico.empleadores.tramites');
    }
}
