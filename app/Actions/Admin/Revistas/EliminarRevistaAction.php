<?php

namespace App\Actions\Admin\Revistas;

use App\Models\Revista;
use Illuminate\Support\Facades\Storage;

class EliminarRevistaAction
{
    public function execute(Revista $revista)
    {
        if ($revista->archivo_pdf && Storage::disk('public')->exists($revista->archivo_pdf)) {
            Storage::disk('public')->delete($revista->archivo_pdf);
        }

        if ($revista->imagen_preview && Storage::disk('public')->exists($revista->imagen_preview)) {
            Storage::disk('public')->delete($revista->imagen_preview);
        }

        $titulo = $revista->titulo;
        $id = $revista->id;
        $deleted = $revista->delete();

        \App\Services\AuditoriaService::registrar(
            'eliminacion',
            "Eliminó la revista digital: '{$titulo}' (ID: {$id})",
            null,
            ['id' => $id, 'titulo' => $titulo]
        );

        return $deleted;
    }
}
