<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ImageOptimizerService;

class UploadEditorImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Control de permisos estricto (CWE-862)
        abort_if(!auth()->user() || (!auth()->user()->can('noticias.crear') && !auth()->user()->can('noticias.editar')), 403, 'Acceso Denegado.');

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'noticias/editor/' . date('Y/m');
            $nombreBase = time() . '_' . Str::random(10);

            // Optimización y conversión automática a WebP (máx 1200px para el cuerpo del artículo)
            $opt = ImageOptimizerService::optimizarYGuardar(
                $file,
                $path,
                $nombreBase,
                1200,
                ImageOptimizerService::CALIDAD_WEBP,
                'public'
            );

            // Generate URL for the frontend
            $url = Storage::disk('public')->url($opt['ruta']);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $url
                ]
            ]);
        }

        return response()->json([
            'success' => 0,
            'message' => 'No image uploaded'
        ], 400);
    }
}
