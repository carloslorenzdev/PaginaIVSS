<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Medio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActualizarNoticiaAction
{
    public function execute(Noticia $noticia, array $data, $archivo = null, $userId = null)
    {
        $slug = Str::slug($data['titulo']);

        $noticia->update([
            'titulo' => $data['titulo'],
            // Update slug only if title changes, or just keep it simple:
            'slug' => $noticia->titulo !== $data['titulo'] ? $slug . '-' . time() : $noticia->slug,
            'contenido' => $data['contenido'] ?? null,
            'resumen' => $data['resumen'],
            'enlace_externo' => $data['enlace_externo'] ?? null,
            'etiquetas' => $data['etiquetas'] ?? null,
            'creditos_autor' => $data['creditos_autor'] ?? null,
        ]);

        if (isset($data['categorias'])) {
            $noticia->categorias()->sync($data['categorias']);
        }

        if ($archivo) {
            $imagenPrincipal = $noticia->medios()->wherePivot('tipo_relacion', 'principal')->first();
            if ($imagenPrincipal) {
                // Delete old image
                Storage::disk('public')->delete($imagenPrincipal->ruta);
                // Update Medio
                $extension = $archivo->getClientOriginalExtension();
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombreOriginalStr = pathinfo($nombreOriginal, PATHINFO_FILENAME);
                $nombreArchivo = time() . '-' . Str::slug($nombreOriginalStr) . '.' . $extension;
                $ruta = $archivo->storeAs('medios', $nombreArchivo, 'public');

                $imagenPrincipal->update([
                    'nombre_original' => $nombreOriginal,
                    'nombre_archivo' => $nombreArchivo,
                    'ruta' => $ruta,
                    'mime_type' => $archivo->getMimeType(),
                    'tamano' => $archivo->getSize(),
                    'leyenda' => $data['leyenda'] ?? $imagenPrincipal->leyenda,
                ]);
            } else {
                // Create Medio
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
                $imagenPrincipal = $medio;
            }
            
            // Sync carrusel image
            \App\Models\Carrusel::where('noticia_id', $noticia->id)->update([
                'imagen_ruta' => $imagenPrincipal->ruta,
                'titulo' => $noticia->titulo,
                'enlace' => $noticia->enlace_externo ?: route('noticias.show', $noticia->slug),
            ]);
            
        } elseif (!empty($data['eliminar_imagen']) && $data['eliminar_imagen'] == '1') {
            $imagenPrincipal = $noticia->medios()->wherePivot('tipo_relacion', 'principal')->first();
            if ($imagenPrincipal) {
                Storage::disk('public')->delete($imagenPrincipal->ruta);
                $noticia->medios()->detach($imagenPrincipal->id);
                $imagenPrincipal->delete();
            }
            
            // Delete from carrusel if it loses its image
            \App\Models\Carrusel::where('noticia_id', $noticia->id)->delete();
        } else {
            // Update carrusel title and link even if image didn't change
            \App\Models\Carrusel::where('noticia_id', $noticia->id)->update([
                'titulo' => $noticia->titulo,
                'enlace' => $noticia->enlace_externo ?: route('noticias.show', $noticia->slug),
            ]);
        }

        return $noticia;
    }
}
