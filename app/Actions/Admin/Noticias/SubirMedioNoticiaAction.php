<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Str;

class SubirMedioNoticiaAction
{
    public function execute($noticiaId, $archivo, array $data, $userId = null)
    {
        $noticia = Noticia::findOrFail($noticiaId);
        
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $tipo = str_starts_with($archivo->getMimeType(), 'video/') ? 'video' : 'imagen';

        if ($tipo === 'imagen') {
            $nombreBase = time() . '-' . Str::slug($nombreOriginalStr);
            $opt = ImageOptimizerService::optimizarYGuardar(
                $archivo,
                'medios',
                $nombreBase,
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
            $mimeType = $archivo->getMimeType();
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

        $orden = $noticia->medios()->max('orden') + 1;

        $noticia->medios()->attach($medio->id, [
            'tipo_relacion' => $data['tipo_relacion'],
            'orden' => $orden
        ]);

        return $medio;
    }
}
