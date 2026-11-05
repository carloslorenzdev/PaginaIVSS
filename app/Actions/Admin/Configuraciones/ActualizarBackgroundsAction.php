<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Facades\Storage;

class ActualizarBackgroundsAction
{
    public function execute(array $archivos)
    {
        $clavesValidas = ['bg_consultas', 'bg_tiuna', 'bg_farmacias', 'bg_centros_salud', 'bg_oficinas', 'bg_servicios_funcionario'];

        foreach ($archivos as $clave => $archivo) {
            if (in_array($clave, $clavesValidas)) {
                $config = Configuracion::firstOrNew(['clave' => $clave]);

                if ($config->exists && $config->valor) {
                    Storage::disk('public')->delete($config->valor);
                }

                $opt = ImageOptimizerService::optimizarYGuardar(
                    $archivo,
                    'modulos',
                    $clave . '-' . time(),
                    ImageOptimizerService::MAX_WIDTH_BANNER,
                    ImageOptimizerService::CALIDAD_WEBP,
                    'public'
                );

                $config->valor = $opt['ruta'];
                $config->save();
            }
        }
    }
}
