<?php

namespace App\Http\Controllers\Admin\Carrusel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Carrusel\GuardarVelocidadCarruselAction;

class GuardarVelocidadCarruselController extends Controller
{
    public function __invoke(Request $request, GuardarVelocidadCarruselAction $action)
    {
        abort_if(!auth()->user()->can('carrusel.editar'), 403, 'No tienes permiso para editar carrusel.');
        $request->validate([
            'intervalo' => 'required|integer|min:1000|max:20000',
        ]);

        $action->execute($request->intervalo);

        return back()->with('success', 'Velocidad del carrusel actualizada correctamente.');
    }
}
