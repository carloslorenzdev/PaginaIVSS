<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\ActividadesAnuales\CrearActividadAnualAction;

class GuardarActividadAnualController extends Controller
{
    public function __invoke(Request $request, CrearActividadAnualAction $action)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200',
            'documento_adjunto' => 'nullable|file|mimes:pdf,doc,docx|max:51200'
        ]);

        $action->execute(
            $request->only(['titulo', 'descripcion', 'activa']),
            $request->file('archivo'),
            $request->file('documento_adjunto'),
            auth()->id()
        );

        return redirect()->route('admin.actividades')->with('success', 'Actividad Anual creada exitosamente.');
    }
}
