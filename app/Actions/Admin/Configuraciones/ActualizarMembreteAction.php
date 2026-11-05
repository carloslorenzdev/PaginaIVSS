<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Facades\Storage;

class ActualizarMembreteAction
{
    public function execute($archivo)
    {
        $config = Configuracion::firstOrNew(['clave' => 'membrete_img']);

        if ($config->exists && $config->valor) {
            Storage::disk('public')->delete($config->valor);
        }

        $opt = ImageOptimizerService::optimizarYGuardar(
            $archivo,
            'modulos',
            'membrete-' . time(),
            ImageOptimizerService::MAX_WIDTH_BANNER,
            ImageOptimizerService::CALIDAD_WEBP,
            'public'
        );

        $config->valor = $opt['ruta'];
        $config->save();

        return $config;
    }
}
