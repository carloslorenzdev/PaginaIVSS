<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\ActividadesAnuales\ActualizarActividadAnualAction;

class ActualizarActividadAnualController extends Controller
{
    public function __invoke(Request $request, $id, ActualizarActividadAnualAction $action)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
        ]);

        $action->execute($id, $request->only(['titulo', 'descripcion', 'activa']));

        return back()->with('success', 'Actividad Anual actualizada correctamente.');
    }
}
