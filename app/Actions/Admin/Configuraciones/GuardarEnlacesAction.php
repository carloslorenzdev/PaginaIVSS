<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;

class GuardarEnlacesAction
{
    public function execute(array $enlaces, array $clavesPermitidas)
    {
        foreach ($clavesPermitidas as $clave) {
            if (array_key_exists($clave, $enlaces)) {
                Configuracion::updateOrCreate(
                    ['clave' => $clave],
                    ['valor' => $enlaces[$clave]]
                );
            }
        }

        return true;
    }
}
