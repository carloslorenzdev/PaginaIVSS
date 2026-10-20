<?php

namespace App\Actions\Admin\Directorios;

use Illuminate\Support\Facades\Cache;
use App\Models\Parroquia;

class ObtenerParroquiasPorMunicipioAction
{
    /**
     * Obtiene las parroquias de un municipio optimizadas y en caché permanente.
     */
    public function execute(int $municipioId): array
    {
        if (!$municipioId) {
            return [];
        }

        return Cache::rememberForever("geo_parroquias_municipio_{$municipioId}", function () use ($municipioId) {
            return Parroquia::where('idmunicipiofk', $municipioId)
                ->select('idparroquia', 'parroquia')
                ->orderBy('parroquia')
                ->get()
                ->toArray();
        });
    }
}
