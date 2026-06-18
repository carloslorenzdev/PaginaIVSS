<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;
use App\Models\Medio;
use Illuminate\Support\Facades\Storage;

class EliminarMedioActividadAction
{
    public function execute($actividadId, $medioId)
    {
        $actividad = ActividadAnual::findOrFail($actividadId);
        $medio = Medio::findOrFail($medioId);

        $actividad->medios()->detach($medioId);
        
        Storage::disk('public')->delete($medio->ruta);
        $medio->delete();

        return true;
    }
}
