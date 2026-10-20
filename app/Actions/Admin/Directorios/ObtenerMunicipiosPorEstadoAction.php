<?php

namespace App\Actions\Admin\Directorios;

use Illuminate\Support\Facades\Cache;
use App\Models\Municipio;

class ObtenerMunicipiosPorEstadoAction
{
    /**
     * Obtiene los municipios de un estado optimizados y en caché permanente.
     */
    public function execute(int $estadoId): array
    {
        if (!$estadoId) {
            return [];
        }

        return Cache::rememberForever("geo_municipios_estado_{$estadoId}", function () use ($estadoId) {
            return Municipio::where('idestadofk', $estadoId)
                ->select('idmunicipio', 'municipio')
                ->orderBy('municipio')
                ->get()
                ->toArray();
        });
    }
}
