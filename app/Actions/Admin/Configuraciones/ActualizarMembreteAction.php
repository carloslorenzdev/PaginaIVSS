<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;

class ActualizarMembreteAction
{
    public function execute($archivo)
    {
        $config = Configuracion::firstOrNew(['clave' => 'membrete_img']);

        if ($config->exists && $config->valor) {
            Storage::disk('public')->delete($config->valor);
        }

        $nombreArchivo = 'membrete-' . time() . '.' . $archivo->getClientOriginalExtension();
        $ruta = $archivo->storeAs('modulos', $nombreArchivo, 'public');

        $config->valor = $ruta;
        $config->save();

        return $config;
    }
}
