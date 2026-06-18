<?php

namespace App\Http\Controllers\Admin\ActividadesAnuales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\ActividadesAnuales\SubirMedioActividadAction;

class SubirMedioActividadController extends Controller
{
    public function __invoke(Request $request, $id, SubirMedioActividadAction $action)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx|max:51200',
            'tipo_relacion' => 'required|in:principal,galeria,adjunto',
            'leyenda' => 'nullable|max:500',
        ]);

        $action->execute(
            $id,
            $request->file('archivo'),
            $request->only(['tipo_relacion', 'leyenda']),
            auth()->id()
        );

        return back()->with('success', 'Medio subido exitosamente a la actividad.');
    }
}
