<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EliminarNoticiaAction
{
    public function execute($id)
    {
        $noticia = Noticia::with('medios')->findOrFail($id);

        // Recopilar medios antes de desvinculación
        $medios = $noticia->medios;

        // Desvincular medios del pivot de la noticia
        $noticia->medios()->detach();

        // Eliminar solo los medios que no estén referenciados en otras noticias o actividades
        foreach ($medios as $medio) {
            $enOtrasNoticias    = $medio->noticias()->count();
            $enOtrasActividades = DB::table('actividad_anual_medios')->where('medio_id', $medio->id)->count();

            if ($enOtrasNoticias === 0 && $enOtrasActividades === 0) {
                Storage::disk('public')->delete($medio->ruta);
                $medio->delete();
            }
        }

        $noticia->delete();

        return true;
    }
}

