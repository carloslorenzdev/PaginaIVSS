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
