<?php

namespace App\Http\Controllers\Admin\Carrusel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Carrusel\ActualizarCarruselAction;

class ActualizarCarruselController extends Controller
{
    public function __invoke(Request $request, $id, ActualizarCarruselAction $action)
    {
        $request->validate([
            'enlace' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'etiquetas' => 'nullable|string|max:255',
            'fecha_publicacion' => 'nullable|date',
            'autor' => 'nullable|string|max:255',
        ]);

        $action->execute($id, $request->only(['enlace', 'titulo', 'etiquetas', 'fecha_publicacion', 'autor']));

        return back()->with('success', 'Enlace e información actualizados correctamente');
    }
}
