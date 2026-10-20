<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Estado;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ResolverEstadoAction
{
    /**
     * Obtener listado de estados directamente desde la tabla nestado (con caché de 24 horas)
     */
    public function getEstados(): array
    {
        return Cache::remember('chatbot_nestados_lista', 86400, function () {
            return Estado::where('idpaisfk', 1)
                ->orderBy('estado')
                ->pluck('estado')
                ->map(fn($e) => trim($e))
                ->filter()
                ->values()
                ->toArray();
        });
    }

    /**
     * Detectar si el texto ingresado por el usuario menciona algún estado de la tabla nestado
     */
    public function detectarEstadoEnTexto(string $texto): ?string
    {
        $textoNormalizado = $this->normalizarTexto($texto);

        // Alias comunes de Distrito Capital
        if (str_contains($textoNormalizado, 'caracas') || str_contains($textoNormalizado, 'distrito capital') || str_contains($textoNormalizado, 'capital')) {
            return 'Distrito Capital';
        }

        $estados = $this->getEstados();

        // Ordenar estados por longitud descendente para evitar falsos positivos con subcadenas cortas
        usort($estados, fn($a, $b) => mb_strlen($b) <=> mb_strlen($a));

        foreach ($estados as $estado) {
            $estadoNormalizado = $this->normalizarTexto($estado);

            if (!empty($estadoNormalizado) && str_contains($textoNormalizado, $estadoNormalizado)) {
                return $estado;
            }
        }

        return null;
    }

    /**
     * Normalizar un nombre de estado (proveniente de GPS, OpenStreetMap o texto) al estado oficial en nestado
     */
    public function normalizar(string $nombreEstado): string
    {
        $textoNormalizado = $this->normalizarTexto($nombreEstado);

        if (str_contains($textoNormalizado, 'capital') || str_contains($textoNormalizado, 'caracas') || str_contains($textoNormalizado, 'federal')) {
            return 'Distrito Capital';
        }

        $estados = $this->getEstados();

        foreach ($estados as $est) {
            $estNormalizado = $this->normalizarTexto($est);
            if (!empty($estNormalizado) && (str_contains($textoNormalizado, $estNormalizado) || str_contains($estNormalizado, $textoNormalizado))) {
                return $est;
            }
        }

        return ucfirst(trim($nombreEstado));
    }

    /**
     * Normalizar texto quitando acentos y convirtiendo a minúsculas
     */
    public function normalizarTexto(string $texto): string
    {
        return Str::ascii(Str::lower(trim($texto)));
    }
}
