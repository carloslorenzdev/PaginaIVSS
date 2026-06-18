<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medio;

class TestSubirController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200',
            'leyenda' => 'nullable|max:500',
        ]);

        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . \Illuminate\Support\Str::slug($nombreOriginalStr) . '.' . $extension;
        $tipo = str_starts_with($archivo->getMimeType(), 'video/') ? 'video' : 'imagen';

        $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');

        Medio::create([
            'tipo' => $tipo,
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'ruta' => $ruta,
            'mime_type' => $archivo->getMimeType(),
            'tamano' => $archivo->getSize(),
            'leyenda' => $request->leyenda,
            'usuario_id' => auth()->id() ?? 1, // Fallback if tested without auth
        ]);

        return redirect('/test-uploads')->with('success', 'Archivo subido exitosamente');
    }
}
