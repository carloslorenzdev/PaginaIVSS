<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
use Illuminate\Support\Str;

class SubirMedioNoticiaAction
{
    public function execute($noticiaId, $archivo, array $data, $userId = null)
    {
        $noticia = Noticia::findOrFail($noticiaId);
        
        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
        $tipo = str_starts_with($archivo->getMimeType(), 'video/') ? 'video' : 'imagen';

        $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');

        $medio = Medio::create([
            'tipo' => $tipo,
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'ruta' => $ruta,
            'mime_type' => $archivo->getMimeType(),
            'tamano' => $archivo->getSize(),
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
