<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;
use Illuminate\Support\Facades\Storage;

class EliminarActividadAnualAction
{
    public function execute($id)
    {
        $actividad = ActividadAnual::findOrFail($id);
        
        foreach ($actividad->medios as $medio) {
            Storage::disk('public')->delete($medio->ruta);
            $medio->delete();
        }
        
        $actividad->delete();

        return true;
    }
}
