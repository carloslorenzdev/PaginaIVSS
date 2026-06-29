<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;

class PensionadoController extends Controller
{
    public function informacionGeneral()
    {
        return view('publico.pensionados.informacion_general');
    }

    public function tiposPensiones()
    {
        return view('publico.pensionados.tipos_pensiones');
    }

    public function pensionadosExterior()
    {
        return view('publico.pensionados.pensionados_exterior');
    }

    public function tramites()
    {
        return view('publico.pensionados.tramites');
    }

    public function contacto()
    {
        return view('publico.pensionados.contacto');
    }

    public function formularios()
    {
        return view('publico.pensionados.formularios');
    }
}
