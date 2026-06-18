<?php

namespace App\Actions\Admin\Carrusel;

use App\Models\Carrusel;

class ActualizarCarruselAction
{
    public function execute($id, array $data)
    {
        $carrusel = Carrusel::findOrFail($id);
        
        $carrusel->update([
            'enlace' => $data['enlace'] ?? null,
            'titulo' => $data['titulo'] ?? null,
            'etiquetas' => $data['etiquetas'] ?? null,
            'fecha_publicacion' => $data['fecha_publicacion'] ?? null,
            'autor' => $data['autor'] ?? null,
        ]);

        return $carrusel;
    }
}
