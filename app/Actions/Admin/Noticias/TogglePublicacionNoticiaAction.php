<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;
use App\Models\Carrusel;
use Carbon\Carbon;

class TogglePublicacionNoticiaAction
{
    public function execute($id, array $data = [])
    {
        $noticia = Noticia::with(['categorias', 'medios'])->findOrFail($id);
        
        if ($noticia->publicado) {
            $noticia->publicado = false;
            $noticia->fecha_publicacion = null;
            
            $enlaceABuscar = $noticia->enlace_externo ?: route('noticias.show', $noticia->slug);
            Carrusel::where('noticia_id', $noticia->id)->orWhere('enlace', $enlaceABuscar)->delete();
        } else {
            $noticia->publicado = true;
            if (!empty($data['fecha_programada'])) {
                $noticia->fecha_publicacion = \Carbon\Carbon::parse($data['fecha_programada']);
            } else {
                $noticia->fecha_publicacion = now();
            }
            
            if (!empty($data['montar_carrusel'])) {
                $imagenPrincipal = $noticia->medios->where('pivot.tipo_relacion', 'principal')->first() ?? $noticia->medios->first();
                if ($imagenPrincipal) {
                    Carrusel::create([
                        'noticia_id' => $noticia->id,
                        'imagen_ruta' => $imagenPrincipal->ruta,
                        'enlace' => $noticia->enlace_externo ?: route('noticias.show', $noticia->slug),
                        'orden' => Carrusel::max('orden') + 1,
                        'titulo' => $noticia->titulo,
                        'etiquetas' => $noticia->categorias->first() ? $noticia->categorias->first()->nombre : 'Noticias',
                        'fecha_publicacion' => $noticia->fecha_publicacion,
                        'autor' => $noticia->autor ? $noticia->autor->name : null,
                    ]);
                }
            }
        }
        
        $noticia->save();
        
        return $noticia;
    }
}
