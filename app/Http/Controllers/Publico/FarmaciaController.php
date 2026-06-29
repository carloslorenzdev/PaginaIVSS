<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Actions\Publico\ObtenerDirectoriosPorTipoAction;

class FarmaciaController extends Controller
{
    public function index(ObtenerDirectoriosPorTipoAction $obtenerDirectorios)
    {
        $data = $obtenerDirectorios->execute('farmacia');
        return view('publico.farmacias.index', compact('data'));
    }
}
