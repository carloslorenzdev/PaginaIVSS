<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Configuraciones\ActualizarBackgroundsAction;

class UpdateBackgroundsController extends Controller
{
    public function __invoke(Request $request, ActualizarBackgroundsAction $action)
    {
        if (env('WEB_EDITABLE', false) == false) {
            abort(404);
        }

        $request->validate([
            'bg_consultas' => 'nullable|image|max:10240',
            'bg_tiuna' => 'nullable|image|max:10240',
            'bg_farmacias' => 'nullable|image|max:10240',
            'bg_centros_salud' => 'nullable|image|max:10240',
            'bg_oficinas' => 'nullable|image|max:10240',
        ]);

        $action->execute($request->allFiles());

        return redirect()->back()->with('success', 'Imágenes de fondo actualizadas correctamente.');
    }
}
