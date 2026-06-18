<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Configuraciones\ActualizarCarruselEstiloAction;

class UpdateCarruselEstiloController extends Controller
{
    public function __invoke(Request $request, ActualizarCarruselEstiloAction $action)
    {
        if (env('WEB_EDITABLE', false) == false) {
            abort(404);
        }

        $request->validate([
            'carrusel_estilo' => 'required|in:default,3d,cinematic'
        ]);

        $action->execute($request->carrusel_estilo);

        return redirect()->back()->with('success', 'Estilo del carrusel actualizado correctamente.');
    }
}
