<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;

class CiudadanoController extends Controller
{
    /**
     * Muestra la vista de Información General
     */
    public function informacionGeneral()
    {
        return view('publico.ciudadanos.informacion_general');
    }

    /**
     * Muestra la vista de Beneficio Médico Integral
     */
    public function beneficioMedico()
    {
        return view('publico.ciudadanos.beneficio_medico');
    }

    /**
     * Muestra la vista de Continuidad Facultativa
     */
    public function continuidadFacultativa()
    {
        return view('publico.ciudadanos.continuidad_facultativa');
    }

    /**
     * Muestra la vista de Pérdida Involuntaria de Empleo
     */
    public function perdidaEmpleo()
    {
        return view('publico.ciudadanos.perdida_empleo');
    }

    /**
     * Muestra la vista de Trámites
     */
    public function tramites()
    {
        return view('publico.ciudadanos.tramites');
    }
}
