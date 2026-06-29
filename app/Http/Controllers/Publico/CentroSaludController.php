<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Actions\Publico\ObtenerDirectoriosPorTipoAction;

class CentroSaludController extends Controller
{
    public function index(ObtenerDirectoriosPorTipoAction $obtenerDirectorios)
    {
        $data = $obtenerDirectorios->execute('centro_salud');
        return view('publico.centros_salud.index', compact('data'));
    }
}
