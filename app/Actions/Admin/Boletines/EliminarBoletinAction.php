<?php

namespace App\Actions\Admin\Boletines;

use App\Models\Boletin;
use Illuminate\Support\Facades\Storage;

class EliminarBoletinAction
{
    public function execute(Boletin $boletin)
    {
        if ($boletin->archivo_pdf && Storage::disk('public')->exists($boletin->archivo_pdf)) {
            Storage::disk('public')->delete($boletin->archivo_pdf);
        }

        if ($boletin->imagen_preview && Storage::disk('public')->exists($boletin->imagen_preview)) {
            Storage::disk('public')->delete($boletin->imagen_preview);
        }

        $titulo = $boletin->titulo;
        $id = $boletin->id;
        $deleted = $boletin->delete();

        \App\Services\AuditoriaService::registrar(
            'eliminacion',
            "Eliminó el boletín: '{$titulo}' (ID: {$id})",
            null,
            ['id' => $id, 'titulo' => $titulo]
        );

        return $deleted;
    }
}
