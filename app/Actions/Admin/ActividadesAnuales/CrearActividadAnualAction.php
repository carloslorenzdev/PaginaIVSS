<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;
use App\Models\Medio;
use Illuminate\Support\Str;

class CrearActividadAnualAction
{
    public function execute(array $data, $archivo = null, $documentoAdjunto = null, $userId = null)
    {
        $actividad = ActividadAnual::create([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'activa' => $data['activa'],
            'autor_id' => $userId,
        ]);

        if ($archivo) {
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
                'usuario_id' => $userId,
            ]);

            $actividad->medios()->attach($medio->id, [
                'tipo_relacion' => 'principal',
                'orden' => 1,
            ]);
        }

        if ($documentoAdjunto) {
            $extensionDoc = $documentoAdjunto->getClientOriginalExtension();
            $nombreOriginalDoc = $documentoAdjunto->getClientOriginalName();
            $nombreOriginalStrDoc = pathinfo($nombreOriginalDoc, PATHINFO_FILENAME);
            $nombreArchivoDoc = time() . '-doc-' . Str::slug($nombreOriginalStrDoc) . '.' . $extensionDoc;
            
            $mimeDoc = $documentoAdjunto->getMimeType();
            $rutaDoc = $documentoAdjunto->storeAs('medios', $nombreArchivoDoc, 'public');

            $medioDoc = Medio::create([
                'tipo' => 'documento',
                'nombre_original' => $nombreOriginalDoc,
                'nombre_archivo' => $nombreArchivoDoc,
                'ruta' => $rutaDoc,
                'mime_type' => $mimeDoc,
                'tamano' => $documentoAdjunto->getSize(),
                'usuario_id' => $userId,
            ]);

            $ordenMax = $actividad->medios()->max('orden') ?? 1;

            $actividad->medios()->attach($medioDoc->id, [
                'tipo_relacion' => 'adjunto',
                'orden' => $ordenMax + 1,
            ]);
        }

        return $actividad;
    }
}
