<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Publico\ObtenerTodasLasNoticiasAction;

class ObtenerTodasLasNoticiasController extends Controller
{
    public function __invoke(Request $request, ObtenerTodasLasNoticiasAction $action)
    {
        $noticias = $action->execute($request->search);

        if ($request->ajax()) {
            return view('partials.noticias-lista', compact('noticias'))->render();
        }

        return view('noticias', compact('noticias'));
    }
}
