<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
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

        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
        $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');

        $medio = Medio::create([
            'tipo' => 'imagen',
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'ruta' => $ruta,
            'mime_type' => $archivo->getMimeType(),
            'tamano' => $archivo->getSize(),
            'usuario_id' => $userId,
            'leyenda' => $data['leyenda'] ?? null,
        ]);

        $noticia->medios()->attach($medio->id, [
            'tipo_relacion' => 'principal',
            'orden' => 1,
        ]);

        return $noticia;
    }
}
