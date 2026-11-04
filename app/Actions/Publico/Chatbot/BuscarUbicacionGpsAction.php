<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Directorio;
use Illuminate\Support\Facades\Http;

class BuscarUbicacionGpsAction
{
    public function __construct(
        protected ResolverEstadoAction $resolverEstado
    ) {}

    public function esConsultaUbicacion(string $mensaje): bool
    {
        return str_starts_with($mensaje, 'ubicacion:') || str_starts_with($mensaje, 'ubicacion_ip:');
    }

    public function execute(string $mensaje): string
    {
        // 1. Ubicación por IP
        if (str_starts_with($mensaje, 'ubicacion_ip:')) {
            $estadoStr = trim(str_replace('ubicacion_ip:', '', $mensaje));
            $estadoNormalizado = $this->resolverEstado->normalizar($estadoStr);
            
            $centros = Directorio::centrosSalud()
                ->where('estado', 'LIKE', "%$estadoNormalizado%")
                ->take(3)
                ->get();
            
            if ($centros->count() > 0) {
                $html = "<b>Según tu conexión de red, te encuentras en {$estadoNormalizado}. Centros de Salud cercanos:</b><br><br>";
                foreach ($centros as $c) {
                    $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                    $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion}<br>";
                    if ($c->telefono) {
                        $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$c->telefono}<br>";
                    }
                    $html .= "<br>";
                }
                return $html;
            }

            return "Te conectas desde {$estadoNormalizado}, pero no encontré centros de salud en nuestros registros para ese estado. Puedes escribir <b>'centros de salud en' seguido de otro estado</b> (Ejemplo: centros de salud en Distrito Capital o Miranda).";
        }

        // 2. Coordenadas GPS del navegador
        if (str_starts_with($mensaje, 'ubicacion:')) {
            $coords = explode(',', str_replace('ubicacion:', '', $mensaje));
            
            if (count($coords) !== 2) {
                return 'Coordenadas geográficas inválidas.';
            }

            $lat = trim($coords[0]);
            $lng = trim($coords[1]);

            if (!is_numeric($lat) || !is_numeric($lng) || $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
                return 'Coordenadas geográficas inválidas.';
            }

            // Cachear y limitar consultas a Nominatim (CWE-770) agrupando por cercanía (~1km)
            $cacheKey = 'nominatim_rev:' . round((float) $lat, 2) . '_' . round((float) $lng, 2);
            $state = \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addDays(7), function () use ($lat, $lng) {
                try {
                    $response = Http::withHeaders([
                        'User-Agent' => 'IVSS-Chatbot/1.0 (Contacto: soporte@ivss.gob.ve)'
                    ])->timeout(4)->get("https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lng}&format=json");

                    if ($response->successful()) {
                        $data = $response->json();
                        $address = $data['address'] ?? [];
                        return $address['state'] ?? $address['state_district'] ?? $address['province'] ?? $address['region'] ?? $address['city'] ?? null;
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Error en consulta externa Nominatim: ' . $e->getMessage());
                }
                return null;
            });

            if ($state) {
                $estadoNormalizado = $this->resolverEstado->normalizar($state);
                
                $centros = Directorio::centrosSalud()
                            ->where('estado', 'LIKE', "%$estadoNormalizado%")
                            ->take(3)
                            ->get();

                        if ($centros->count() > 0) {
                            $html = "<b>Centros de Salud cercanos a ti ({$estadoNormalizado}):</b><br><br>";
                            foreach ($centros as $c) {
                                $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                                $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion}<br>";
                                if ($c->telefono) {
                                    $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$c->telefono}<br>";
                                }
                                $html .= "<br>";
                            }
                            return $html;
                        }

                        return "Detectamos tu ubicación en {$estadoNormalizado}, pero no encontramos centros de salud registrados en el sistema para esa región. Puedes escribir <b>'centros de salud en' seguido de tu estado</b> (Ejemplo: centros de salud en Distrito Capital o Miranda).";
            }

            return "Obtuvimos tus coordenadas, pero tuvimos problemas determinando tu estado exacto en nuestros registros. Por favor escribe <b>'centros de salud en' seguido de tu estado</b> (Ejemplo: centros de salud en Distrito Capital o Miranda).";
        }

        return 'No se pudo procesar la solicitud de ubicación.';
    }
}
