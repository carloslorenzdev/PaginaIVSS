<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Str;

class CrearNoticiaAction
{
    public function execute(array $data, $archivo, $userId = null)
    {
        $slug = Str::slug($data['titulo']);

        $noticia = Noticia::create([
            'titulo' => $data['titulo'],
            'slug' => $slug . '-' . time(),
            'contenido' => $data['contenido'] ?? null,
            'resumen' => $data['resumen'],
            'autor_id' => $userId,
            'enlace_externo' => $data['enlace_externo'] ?? null,
            'publicado' => false,
            'fecha_publicacion' => null,
            'etiquetas' => $data['etiquetas'] ?? null,
            'creditos_autor' => $data['creditos_autor'] ?? null,
        ]);

        if (!empty($data['categorias'])) {
            $noticia->categorias()->sync($data['categorias']);
        }

        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $nombreBase = time() . '-' . Str::slug($nombreOriginalStr);

        // Conversión y optimización automática a WebP (reduce 75-90% de peso)
        $opt = ImageOptimizerService::optimizarYGuardar(
            $archivo,
            'medios',
            $nombreBase,
            ImageOptimizerService::MAX_WIDTH_NOTICIA,
            ImageOptimizerService::CALIDAD_WEBP,
            'public'
        );

        $medio = Medio::create([
            'tipo' => 'imagen',
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $opt['nombre_archivo'],
            'ruta' => $opt['ruta'],
            'mime_type' => $opt['mime_type'],
            'tamano' => $opt['tamano'],
            'usuario_id' => $userId,
            'leyenda' => $data['leyenda'] ?? null,
        ]);

        $noticia->medios()->attach($medio->id, [
            'tipo_relacion' => 'principal',
            'orden' => 1,
        ]);

        \App\Services\AuditoriaService::registrar(
            'creacion',
            "Creó la noticia: '{$noticia->titulo}'",
            $noticia,
            ['titulo' => $noticia->titulo, 'resumen' => $noticia->resumen]
        );

        return $noticia;
    }
}
