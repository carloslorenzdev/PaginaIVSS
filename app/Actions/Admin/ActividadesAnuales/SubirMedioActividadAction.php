<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;
use App\Models\Medio;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Str;

class SubirMedioActividadAction
{
    public function execute($id, $archivo, array $data, $userId = null)
    {
        $actividad = ActividadAnual::findOrFail($id);
        
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $mime = $archivo->getMimeType();
        $tipo = 'documento';
        if (str_starts_with($mime, 'image/')) {
            $tipo = 'imagen';
        } elseif (str_starts_with($mime, 'video/')) {
            $tipo = 'video';
        }

        if ($tipo === 'imagen') {
            $opt = ImageOptimizerService::optimizarYGuardar(
                $archivo,
                'medios',
                time() . '-' . Str::slug($nombreOriginalStr),
                ImageOptimizerService::MAX_WIDTH_NOTICIA,
                ImageOptimizerService::CALIDAD_WEBP,
                'public'
            );
            $ruta = $opt['ruta'];
            $nombreArchivo = $opt['nombre_archivo'];
            $mimeType = $opt['mime_type'];
            $tamano = $opt['tamano'];
        } else {
            $extension = $archivo->extension() ?: $archivo->guessExtension() ?: 'bin';
            $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
            $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');
            $mimeType = $mime;
            $tamano = $archivo->getSize();
        }

        $medio = Medio::create([
            'tipo' => $tipo,
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'ruta' => $ruta,
            'mime_type' => $mimeType,
            'tamano' => $tamano,
            'leyenda' => $data['leyenda'] ?? null,
            'usuario_id' => $userId,
        ]);

        $orden = $actividad->medios()->max('orden') + 1;

        $actividad->medios()->attach($medio->id, [
            'tipo_relacion' => $data['tipo_relacion'],
            'orden' => $orden,
        ]);

        return $medio;
    }
}
