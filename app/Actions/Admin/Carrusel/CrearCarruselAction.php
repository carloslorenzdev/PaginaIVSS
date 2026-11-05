<?php

namespace App\Actions\Admin\Carrusel;

use App\Models\Carrusel;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Str;

class CrearCarruselAction
{
    public function execute(array $data, $archivo)
    {
        $nombreOriginalStr = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
        $nombreBase = time() . '-' . Str::slug($nombreOriginalStr);

        // Optimización y conversión automática a WebP panorámico (1920px)
        $opt = ImageOptimizerService::optimizarYGuardar(
            $archivo,
            'carrusel',
            $nombreBase,
            ImageOptimizerService::MAX_WIDTH_BANNER,
            ImageOptimizerService::CALIDAD_WEBP,
            'public'
        );

        $carrusel = Carrusel::create([
            'imagen_ruta' => $opt['ruta'],
            'enlace' => $data['enlace'] ?? null,
            'orden' => $data['orden'] ?? (Carrusel::max('orden') + 1),
            'titulo' => $data['titulo'] ?? null,
            'etiquetas' => $data['etiquetas'] ?? null,
            'fecha_publicacion' => $data['fecha_publicacion'] ?? null,
            'autor' => $data['autor'] ?? null,
        ]);

        Carrusel::limitarAMaximo(10);

        return $carrusel;
    }
}
