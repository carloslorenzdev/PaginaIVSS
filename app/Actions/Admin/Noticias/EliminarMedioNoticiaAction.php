<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EliminarMedioNoticiaAction
{
    public function execute($noticiaId, $medioId)
    {
        $noticia = Noticia::findOrFail($noticiaId);
        $medio = Medio::findOrFail($medioId);

        // Desvincula el medio de esta noticia
        $noticia->medios()->detach($medioId);

        // Verifica si el medio todavía está referenciado en otras noticias o actividades anuales
        $enOtrasNoticias    = $medio->noticias()->count();
        $enOtrasActividades = DB::table('actividad_anual_medios')->where('medio_id', $medio->id)->count();

        if ($enOtrasNoticias === 0 && $enOtrasActividades === 0) {
            Storage::disk('public')->delete($medio->ruta);
            $medio->delete();
        }

        return true;
    }
}

