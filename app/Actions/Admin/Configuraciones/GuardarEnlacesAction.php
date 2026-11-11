<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;

class GuardarEnlacesAction
{
    public function execute(array $enlaces, array $clavesPermitidas)
    {
        foreach ($clavesPermitidas as $clave) {
            if (array_key_exists($clave, $enlaces)) {
                $valor = is_string($enlaces[$clave]) ? trim($enlaces[$clave]) : $enlaces[$clave];
                Configuracion::updateOrCreate(
                    ['clave' => $clave],
                    ['valor' => $valor]
                );
            }

            $visKey = 'visible_' . $clave;
            if (array_key_exists($visKey, $enlaces)) {
                Configuracion::updateOrCreate(
                    ['clave' => $visKey],
                    ['valor' => (string)$enlaces[$visKey]]
                );
            }
        }

        return true;
    }
}
