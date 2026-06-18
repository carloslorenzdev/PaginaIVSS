<?php

namespace App\Actions\Admin\ActividadesAnuales;

use App\Models\ActividadAnual;

class ObtenerActividadesAnualesAction
{
    public function execute($search = null)
    {
        $query = ActividadAnual::with('autor');

        if ($search) {
            $searchStr = strtolower($search);
            $query->whereRaw('LOWER(titulo) LIKE ?', ["%{$searchStr}%"]);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}
