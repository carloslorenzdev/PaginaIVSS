<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use App\Models\Boletin;
use Illuminate\Http\Request;

class BoletinInformativoController extends Controller
{
    public function index()
    {
        $boletines = Boletin::where('publicado', true)
                            ->orderBy('fecha_publicacion', 'desc')
                            ->paginate(12);

        return view('servicios_complementarios.boletines', compact('boletines'));
    }
}
