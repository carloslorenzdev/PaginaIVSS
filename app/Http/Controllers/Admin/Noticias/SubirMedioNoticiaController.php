<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Noticias\SubirMedioNoticiaAction;

class SubirMedioNoticiaController extends Controller
{
    public function __invoke(Request $request, $noticiaId, SubirMedioNoticiaAction $action)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'redactor', 'aprobador']), 403, 'No tienes permiso para subir medios.');

        $request->validate([
            'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:51200',
            'tipo_relacion' => 'required|in:principal,galeria,adjunto',
            'leyenda' => 'nullable|max:500',
        ]);

        $action->execute(
            $noticiaId,
            $request->file('archivo'),
            $request->only(['tipo_relacion', 'leyenda']),
            auth()->id()
        );

        return back()->with('success', 'Medio subido y adjuntado exitosamente.');
    }
}
