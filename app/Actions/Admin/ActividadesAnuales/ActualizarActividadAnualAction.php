<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;

class ActualizarActividadAnualAction
{
    public function execute($id, array $data)
    {
        $actividad = ActividadAnual::findOrFail($id);
        
        $actividad->update([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'activa' => $data['activa'],
        ]);

        return $actividad;
    }
}
