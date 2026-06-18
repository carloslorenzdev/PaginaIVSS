<?php

namespace App\Http\Controllers\Admin\Carrusel;

use App\Http\Controllers\Controller;
use App\Models\Carrusel;
use App\Models\Configuracion;

class GestionarCarruselController extends Controller
{
    public function __invoke()
    {
        $carruseles = Carrusel::orderBy('orden')->get();
        $configuracion = Configuracion::where('clave', 'carrusel_intervalo')->first();
        $intervalo = $configuracion ? $configuracion->valor : 5000;
        return view('admin.carrusel.index', compact('carruseles', 'intervalo'));
    }
}
