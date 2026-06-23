<?php

namespace App\Actions\Publico;

use App\Models\Revista;

class ObtenerRevistasPublicasAction
{
    public function execute($perPage = 12)
    {
        return Revista::where('publicado', true)
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate($perPage);
    }
}
