<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuardarModuloAction
{
    public function execute($clave, $archivo)
    {
        $config = Configuracion::firstOrNew(['clave' => $clave]);

        if ($config->exists && $config->valor) {
            Storage::disk('public')->delete($config->valor);
        }

        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginalStr = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
        $ruta = $archivo->storeAs('modulos', $nombreArchivo, 'public');

        $config->valor = $ruta;
        $config->save();

        return $config;
    }
}
