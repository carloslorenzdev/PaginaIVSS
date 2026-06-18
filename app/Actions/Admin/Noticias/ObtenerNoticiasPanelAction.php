<?php

namespace App\Actions\Admin\Noticias;

use App\Models\Noticia;

class ObtenerNoticiasPanelAction
{
    public function execute($search = null)
    {
        $query = Noticia::with(['categorias', 'autor']);

        if ($search) {
            $searchStr = strtolower($search);
            $query->where(function($q) use ($searchStr) {
                $q->whereRaw('LOWER(titulo) LIKE ?', ["%{$searchStr}%"])
                  ->orWhereRaw('LOWER(resumen) LIKE ?', ["%{$searchStr}%"]);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}
