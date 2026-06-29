<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Actions\Publico\ObtenerDirectoriosPorTipoAction;

class OficinaAdministrativaController extends Controller
{
    public function index(ObtenerDirectoriosPorTipoAction $obtenerDirectorios)
    {
        $data = $obtenerDirectorios->execute('oficina_administrativa');
        return view('publico.oficinas_administrativas.index', compact('data'));
    }
}
