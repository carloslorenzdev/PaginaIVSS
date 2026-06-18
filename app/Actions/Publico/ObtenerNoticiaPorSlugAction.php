<?php

namespace App\Actions\Publico;

use App\Models\Noticia;

class ObtenerNoticiaPorSlugAction
{
    public function execute($slug)
    {
        return Noticia::with(['medios', 'autor'])
            ->where('slug', $slug)
            ->where('publicado', true)
            ->where('fecha_publicacion', '<=', now())
            ->firstOrFail();
    }
}
