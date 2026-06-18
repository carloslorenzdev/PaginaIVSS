<?php

namespace App\Actions\Admin\Carrusel;

use App\Models\Configuracion;

class GuardarVelocidadCarruselAction
{
    public function execute($intervalo)
    {
        return Configuracion::updateOrCreate(
            ['clave' => 'carrusel_intervalo'],
            ['valor' => $intervalo]
        );
    }
}
