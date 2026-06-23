<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Actions\Publico\ObtenerRevistasPublicasAction;

class RevistaController extends Controller
{
    public function index(ObtenerRevistasPublicasAction $obtenerRevistasPublicasAction)
    {
        $revistas = $obtenerRevistasPublicasAction->execute();

        return view('publico.revistas.index', compact('revistas'));
    }

    public function show(\App\Models\Revista $revista)
    {
        if (!$revista->publicado) {
            abort(404);
        }
        
        return view('publico.revistas.show', compact('revista'));
    }
}
