<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\ActividadesAnuales\ActualizarActividadAnualAction;

class ActualizarActividadAnualController extends Controller
{
    public function __invoke(Request $request, $id, ActualizarActividadAnualAction $action)
    {
        abort_if(!auth()->user()->can('actividades.editar'), 403, 'No tienes permiso para editar actividades.');
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
        ]);

        $data = $request->only(['titulo', 'activa']);
        $data['descripcion'] = clean($request->input('descripcion'));

        $action->execute($id, $data);

        return back()->with('success', 'Actividad Anual actualizada correctamente.');
    }
}
