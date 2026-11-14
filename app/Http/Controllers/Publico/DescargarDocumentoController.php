<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\DocumentoInstitucional;
use Illuminate\Support\Facades\Storage;

class DescargarDocumentoController extends Controller
{
    /**
     * Descarga el archivo de un documento institucional con su nombre oficial limpio
     */
    public function descargar(int $id)
    {
        $doc = DocumentoInstitucional::findOrFail($id);

        if (!$doc->archivo_path || !Storage::disk('public')->exists($doc->archivo_path)) {
            abort(404, 'El archivo solicitado no se encuentra disponible.');
        }

        // Incrementar el contador de descargas
        $doc->increment('descargas');

        // Determinar la extensión
        $extension = strtolower($doc->formato ?: pathinfo($doc->archivo_path, PATHINFO_EXTENSION));
        if (empty($extension)) {
            $extension = 'pdf';
        }

        // Generar un nombre de archivo limpio basado en el título oficial del documento
        $tituloLimpio = preg_replace('~[\\\\/:*?"<>|]~', ' ', $doc->titulo);
        $tituloLimpio = trim(preg_replace('/\s+/', ' ', $tituloLimpio));
        $nombreDescarga = $tituloLimpio . '.' . $extension;

        return Storage::disk('public')->download($doc->archivo_path, $nombreDescarga);
    }
}

