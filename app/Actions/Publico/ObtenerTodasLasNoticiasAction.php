<?php

namespace App\Actions\Publico;

use App\Models\Noticia;

class ObtenerTodasLasNoticiasAction
{
    public function execute($search = null)
    {
        $query = Noticia::with(['medios' => function($q) {
            $q->where('noticias_medios.tipo_relacion', 'principal');
        }])->where('publicado', true)
           ->where('fecha_publicacion', '<=', now());

        if ($search) {
            $searchStr = strtolower($search);
            $query->where(function($q) use ($searchStr) {
                $q->whereRaw('LOWER(titulo) LIKE ?', ["%{$searchStr}%"])
                  ->orWhereRaw('LOWER(resumen) LIKE ?', ["%{$searchStr}%"]);
            });
        }

        return $query->orderBy('fecha_publicacion', 'desc')->paginate(10);
    }
}
