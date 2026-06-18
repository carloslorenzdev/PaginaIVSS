<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;
use App\Models\Medio;
use Illuminate\Support\Str;

class SubirMedioActividadAction
{
    public function execute($id, $archivo, array $data, $userId = null)
    {
        $actividad = ActividadAnual::findOrFail($id);
        
        $extension = $archivo->getClientOriginalExtension();
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
        
        $mime = $archivo->getMimeType();
        $tipo = 'documento';
        if (str_starts_with($mime, 'image/')) {
            $tipo = 'imagen';
        } elseif (str_starts_with($mime, 'video/')) {
            $tipo = 'video';
        }

        $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');

        $medio = Medio::create([
            'tipo' => $tipo,
            'nombre_original' => $nombreOriginal,
            'nombre_archivo' => $nombreArchivo,
            'ruta' => $ruta,
            'mime_type' => $mime,
            'tamano' => $archivo->getSize(),
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
