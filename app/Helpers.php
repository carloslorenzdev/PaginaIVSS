<?php

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

if (!function_exists('routeActive')) {
    /**
     * Valida que la ruta actual exista en la pasada por parametro
     * @param array|string $routesNames Rutas a validar
     * @return bool
     */
    function routeActive(array|string $routesNames): bool
    {
        /** @var Request */
        $request = request();
        if (!is_array($routesNames)) {
            $routesNames = [$routesNames];
        }
        foreach ($routesNames as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
}

if (!Carbon::hasMacro('fechaHumanos')) {
    Carbon::macro('fechaHumanos', static function (CarbonInterface|\DateTimeInterface|string|null $dateComparison = null) {
        /** @var Carbon $date */
        $date = self::this();
        // MISMO DIA MENOR A 3 HORAS
        if ($date->diffInHours($dateComparison) < 3) {
            // hace 1 minutos/horas
            return $date->diffForHumans();
        }

        return $date->calendar($dateComparison, [
            'lastDay' => '[ayer], h:mm a',
            'sameDay' => '[hoy], h:mm a',
            'nextDay' => '[mañana], h:mm a',
            'nextWeek' => '[el] dddd, h:mm a',
            // martes, 2:22 p.m.
            'lastWeek' => 'dddd, h:mm a',
            // 7 jun. 2025, 2:22 p.m.
            'sameElse' => 'D MMM Y, h:mm a'
        ]);
    });
}

if (!function_exists('formatear_enlace')) {
    /**
     * Normaliza un enlace dinámico para su renderizado seguro en atributos href
     * - Si está vacío o es '#', retorna '#'
     * - Si empieza por '/', 'mailto:', 'tel:' o '#', se mantiene tal cual.
     * - Si tiene 'https://' con puertos HTTP legacy (28080-28089, 9090), lo corrige a 'http://'
     *   para evitar fallos de protocolo SSL / Connection Timeout.
     * - Si empieza por 'www.' o un dominio/IP sin protocolo, le antepone 'http://'
     *   para que el navegador no lo abra como ruta relativa local.
     * - Si ya tiene protocolo (http:// o https://), se preserva tal cual.
     *
     * @param string|null $url
     * @return string
     */
    function formatear_enlace(?string $url): string
    {
        if (empty($url) || trim($url) === '' || trim($url) === '#') {
            return '#';
        }

        $url = trim($url);

        // Rutas relativas, anclas o esquemas especiales
        if (str_starts_with($url, '/') || str_starts_with($url, '#') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:')) {
            return $url;
        }

        // Si viene con https pero apunta a puertos legacy de servicios internos (28080-28089 o 9090),
        // corregir a http:// porque esos puertos son exclusivamente HTTP y carecen de SSL.
        if (preg_match('~^https://([^/:]+:(?:2808\d|9090))(/.*)?$~i', $url, $coincidencias)) {
            return 'http://' . $coincidencias[1] . ($coincidencias[2] ?? '');
        }

        // Si no tiene esquema (inicia con www. o nombre de host/IP)
        if (!preg_match('~^[a-zA-Z][a-zA-Z0-9+.-]*://~', $url)) {
            return 'http://' . $url;
        }

        return $url;
    }
}
