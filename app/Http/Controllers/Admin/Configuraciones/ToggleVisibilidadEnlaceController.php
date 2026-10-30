<?php

namespace App\Http\Controllers\Admin\Configuraciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Services\AuditoriaService;

class ToggleVisibilidadEnlaceController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!auth()->user()->can('configuracion.enlaces')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $request->validate([
            'clave' => 'required|string|max:100',
        ]);

        $clave = $request->input('clave');
        $visKey = 'visible_' . $clave;

        $actual = Configuracion::where('clave', $visKey)->value('valor');
        $nuevo = ($actual === '0') ? '1' : '0';

        Configuracion::updateOrCreate(
            ['clave' => $visKey],
            ['valor' => $nuevo]
        );

        AuditoriaService::registrar(
            'edicion',
            "Cambió la visibilidad del enlace '{$clave}' a: " . ($nuevo === '1' ? 'Visible' : 'Oculto'),
            null,
            ['clave' => $clave, 'visible' => $nuevo]
        );

        return response()->json([
            'success' => true,
            'clave' => $clave,
            'visible' => $nuevo === '1',
            'valor' => $nuevo,
            'message' => $nuevo === '1' ? 'Enlace ahora visible al público' : 'Enlace ocultado al público',
        ]);
    }
}

