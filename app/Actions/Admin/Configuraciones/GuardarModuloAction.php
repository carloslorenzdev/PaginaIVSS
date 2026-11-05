<?php

namespace App\Actions\Admin\Configuraciones;

use App\Models\Configuracion;
use App\Services\ImageOptimizerService;
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

        $nombreOriginalStr = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
        $nombreBase = time() . '-' . Str::slug($nombreOriginalStr);

        $opt = ImageOptimizerService::optimizarYGuardar(
            $archivo,
            'modulos',
            $nombreBase,
            ImageOptimizerService::MAX_WIDTH_BANNER,
            ImageOptimizerService::CALIDAD_WEBP,
            'public'
        );

        $config->valor = $opt['ruta'];
        $config->save();

        return $config;
    }
}
