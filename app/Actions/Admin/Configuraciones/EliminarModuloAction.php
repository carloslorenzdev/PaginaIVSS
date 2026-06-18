<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;

class EliminarModuloAction
{
    public function execute($clave)
    {
        $config = Configuracion::where('clave', $clave)->first();

        if ($config && $config->valor) {
            Storage::disk('public')->delete($config->valor);
            $config->delete();
        }

        return true;
    }
}
