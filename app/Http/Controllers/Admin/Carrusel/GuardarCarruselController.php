<?php

namespace App\Http\Controllers\Admin\Carrusel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Carrusel\CrearCarruselAction;

class GuardarCarruselController extends Controller
{
    public function __invoke(Request $request, CrearCarruselAction $action)
    {
        abort_if(!auth()->user()->can('carrusel.crear'), 403, 'No tienes permiso para crear carrusel.');
        $request->validate([
            'enlace' => 'nullable|string|max:255',
            'archivo' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
            'orden' => 'nullable|integer',
        ]);

        $action->execute(
            $request->only(['enlace', 'orden', 'titulo', 'etiquetas', 'fecha_publicacion', 'autor']),
            $request->file('archivo')
        );

        return back()->with('success', 'Imagen añadida al carrusel');
    }
}
