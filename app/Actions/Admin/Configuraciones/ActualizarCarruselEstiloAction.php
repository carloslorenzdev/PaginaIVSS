<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;

class ActualizarCarruselEstiloAction
{
    public function execute($estilo)
    {
        return Configuracion::updateOrCreate(
            ['clave' => 'carrusel_estilo'],
            ['valor' => $estilo]
        );
    }
}
