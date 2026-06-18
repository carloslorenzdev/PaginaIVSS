<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;

class ActualizarBackgroundsAction
{
    public function execute(array $archivos)
    {
        $clavesValidas = ['bg_consultas', 'bg_tiuna', 'bg_farmacias', 'bg_centros_salud', 'bg_oficinas'];

        foreach ($archivos as $clave => $archivo) {
            if (in_array($clave, $clavesValidas)) {
                $config = Configuracion::firstOrNew(['clave' => $clave]);

                if ($config->exists && $config->valor) {
                    Storage::disk('public')->delete($config->valor);
                }

                $nombreArchivo = $clave . '-' . time() . '.' . $archivo->getClientOriginalExtension();
                $ruta = $archivo->storeAs('modulos', $nombreArchivo, 'public');

                $config->valor = $ruta;
                $config->save();
            }
        }
    }
}
