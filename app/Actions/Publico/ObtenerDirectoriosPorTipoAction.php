<?php

namespace App\Actions\Publico;

use App\Models\Directorio;

class ObtenerDirectoriosPorTipoAction
{
    public function execute(string $tipo)
    {
        return Directorio::where('tipo', $tipo)->get()->groupBy('estado');
    }
}
