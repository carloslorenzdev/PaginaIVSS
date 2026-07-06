<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Directorio;

class ProcesarMensajeChatbotAction
{
    public function execute(string $mensaje): string
    {
        $mensajeOriginal = $mensaje;
        $mensaje = strtolower($mensaje);
        
        // Quitar acentos rudimentario para simplificar busqueda
        $mensaje = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ä', 'ë', 'ï', 'ö', 'ü'],
            ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'],
            $mensaje
        );

        // Ubicación Automática (Geolocalización por IP o GPS)
        if (str_starts_with($mensaje, 'ubicacion_ip:')) {
            $estadoStr = trim(str_replace('ubicacion_ip:', '', $mensaje));
            
            $estadoNormalizado = $this->normalizarEstado($estadoStr);
            $centros = Directorio::centrosSalud()->where('estado', 'LIKE', "%$estadoNormalizado%")->take(3)->get();
            
            if ($centros->count() > 0) {
                $html = "<b>Según tu conexión de red, te encuentras en {$estadoNormalizado}. Centros de Salud cercanos:</b><br><br>";
                foreach ($centros as $c) {
                    $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                    $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion}<br>";
                    if ($c->telefono) $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$c->telefono}<br>";
                    $html .= "<br>";
                }
                return $html;
            } else {
                return "Te conectas desde {$estadoNormalizado}, pero no encontré centros de salud en nuestros registros para ese estado.";
            }
        }
        
        if (str_starts_with($mensaje, 'ubicacion:')) {
            $coords = explode(',', str_replace('ubicacion:', '', $mensaje));
            if (count($coords) == 2) {
                $lat = trim($coords[0]);
                $lng = trim($coords[1]);
                
                try {
                    $response = \Illuminate\Support\Facades\Http::withHeaders([
                        'User-Agent' => 'IVSS-Chatbot/1.0'
                    ])->timeout(5)->get("https://nominatim.openstreetmap.org/reverse?lat={$lat}&lon={$lng}&format=json");
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        $state = $data['address']['state'] ?? null;
                        
                        if ($state) {
                            $estadoNormalizado = $this->normalizarEstado($state);
                            
                            $centros = Directorio::centrosSalud()->where('estado', 'LIKE', "%$estadoNormalizado%")->take(3)->get();
                            
                            if ($centros->count() > 0) {
                                $html = "<b>Centros de Salud cercanos a ti ({$estadoNormalizado}):</b><br><br>";
                                foreach ($centros as $c) {
                                    $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                                    $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion}<br>";
                                    if ($c->telefono) $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$c->telefono}<br>";
                                    $html .= "<br>";
                                }
                                return $html;
                            } else {
                                return "Lo siento, no encontré centros de salud en nuestros registros para tu estado ({$estadoNormalizado}).";
                            }
                        }
                    }
                } catch (\Exception $e) {
                    return "Hubo un problema de red intentando localizar tu ubicación exacta.";
                }
                
                return "Obtuvimos tu ubicación, pero tuvimos problemas determinando tu estado exacto en nuestros registros.";
            }
        }

        // 1. Detección de Farmacias (solo cuando se busca ubicación física)
        if (str_contains($mensaje, 'farmacia')) {
            // Extraer posible ubicación
            $estados = ['amazonas', 'anzoategui', 'apure', 'aragua', 'barinas', 'bolivar', 'carabobo', 'cojedes', 'delta amacuro', 'falcon', 'guarico', 'lara', 'merida', 'miranda', 'monagas', 'nueva esparta', 'portuguesa', 'sucre', 'tachira', 'trujillo', 'vargas', 'yaracuy', 'zulia', 'caracas'];
            $estadoDetectado = null;
            foreach($estados as $estado) {
                if(str_contains($mensaje, $estado)) {
                    $estadoDetectado = ucfirst($estado);
                    if ($estadoDetectado == 'Caracas') $estadoDetectado = 'Distrito Capital';
                    break;
                }
            }

            // Si encontró un estado, buscamos en BD
            if ($estadoDetectado) {
                $farmacias = Directorio::farmacias()
                    ->where(function($q) use ($estadoDetectado, $estado) {
                        $q->where('estado', 'LIKE', "%$estadoDetectado%")
                          ->orWhere('direccion', 'LIKE', "%$estado%");
                    })->take(3)->get();
                
                if ($farmacias->count() > 0) {
                    $html = "<b>Farmacias de Alto Costo encontradas en nuestro sistema:</b><br><br>";
                    foreach ($farmacias as $f) {
                        $html .= "<i class=\"fas fa-clinic-medical text-primary\"></i> <b>{$f->nombre}</b><br>";
                        $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$f->direccion} ({$f->estado})<br>";
                        if ($f->telefono) $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$f->telefono}<br>";
                        $html .= "<br>";
                    }
                    return $html;
                } else {
                    return "Lo siento, no encontré farmacias de alto costo específicas para esa ubicación en nuestros registros. Puedes comunicarte al 0800-IVSS para mayor información.";
                }
            }
        }

        // 2. Detección de Centros de Salud en Base de Datos
        if (str_contains($mensaje, 'hospital') || str_contains($mensaje, 'clinica') || str_contains($mensaje, 'ambulatorio') || str_contains($mensaje, 'centro de salud') || str_contains($mensaje, 'centros de salud') || str_contains($mensaje, 'emergencia') || str_contains($mensaje, 'hemodialisis') || str_contains($mensaje, 'dialisis')) {
            // Extraer posible ubicación
            $estados = ['amazonas', 'anzoategui', 'apure', 'aragua', 'barinas', 'bolivar', 'carabobo', 'cojedes', 'delta amacuro', 'falcon', 'guarico', 'lara', 'merida', 'miranda', 'monagas', 'nueva esparta', 'portuguesa', 'sucre', 'tachira', 'trujillo', 'vargas', 'yaracuy', 'zulia', 'caracas'];
            $estadoDetectado = null;
            foreach($estados as $estado) {
                if(str_contains($mensaje, $estado)) {
                    $estadoDetectado = ucfirst($estado);
                    if ($estadoDetectado == 'Caracas') $estadoDetectado = 'Distrito Capital';
                    break;
                }
            }

            if ($estadoDetectado) {
                $centros = Directorio::centrosSalud()
                    ->where(function($q) use ($estadoDetectado, $estado) {
                        $q->where('estado', 'LIKE', "%$estadoDetectado%")
                          ->orWhere('direccion', 'LIKE', "%$estado%");
                    })->take(3)->get();
                
                if ($centros->count() > 0) {
                    $html = "<b>Centros de Salud encontrados en nuestro sistema ($estadoDetectado):</b><br><br>";
                    foreach ($centros as $c) {
                        $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                        $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion} ({$c->estado})<br><br>";
                    }
                    return $html;
                } else {
                    return "Lo siento, no tengo centros de salud registrados en el sistema para esa ubicación exacta.";
                }
            }
        }

        // 3. BASE DE CONOCIMIENTO DINÁMICA
        $mensajeLimpio = $this->normalizarTexto($mensajeOriginal);
        $conocimientos = \App\Models\ChatbotConocimiento::activos()->get();
        
        $mejorConocimiento = null;
        $maxPuntaje = 0;

        foreach ($conocimientos as $conocimiento) {
            // Let's get the keywords cleanly:
            $palabrasClaveOriginales = array_map('trim', explode(',', $conocimiento->palabras_clave));
            $palabrasClave = [];
            foreach ($palabrasClaveOriginales as $p) {
                $pLimpia = $this->normalizarTexto($p);
                if (!empty($pLimpia)) {
                    $palabrasClave[] = $pLimpia;
                }
            }

            // También añadimos la pregunta literal como palabra clave
            $preguntaLimpia = $this->normalizarTexto($conocimiento->pregunta);
            if (!empty($preguntaLimpia) && !in_array($preguntaLimpia, $palabrasClave)) {
                $palabrasClave[] = $preguntaLimpia;
            }

            $puntaje = 0;
            
            foreach ($palabrasClave as $palabra) {
                if (!empty($palabra) && str_contains($mensajeLimpio, $palabra)) {
                    // Dar más peso a palabras más largas o específicas
                    $puntaje += strlen($palabra);
                }
            }
            
            if ($puntaje > $maxPuntaje) {
                $maxPuntaje = $puntaje;
                $mejorConocimiento = $conocimiento;
            }
        }

        if ($mejorConocimiento && $maxPuntaje > 0) {
            return $mejorConocimiento->respuesta;
        }

        // 4. Fallback estricto - Guardar la pregunta sin respuesta
        $existe = \App\Models\ChatbotPreguntaSinRespuesta::where('pregunta', $mensajeOriginal)->exists();
        if (!$existe) {
            \App\Models\ChatbotPreguntaSinRespuesta::create([
                'pregunta' => $mensajeOriginal
            ]);
        }

        return 'Lo siento, soy un Asistente del IVSS configurado exclusivamente para orientación de trámites y consultas institucionales. No cuento con IA externa ni conexión a Internet abierta para responder a esa solicitud. ¿Te puedo ayudar buscando alguna farmacia, centro de salud, trámite de RRHH o del Sistema Tiuna?';
    }

    private function contieneAlguna(string $texto, array $palabras): bool
    {
        foreach ($palabras as $palabra) {
            if (str_contains($texto, $palabra)) {
                return true;
            }
        }
        return false;
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = strtolower(trim($texto));
        // Quitar acentos
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ä', 'ë', 'ï', 'ö', 'ü', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n'],
            $texto
        );
        // Quitar signos de puntuación comunes que puedan afectar el match exacto
        $texto = str_replace(['?', '¿', '!', '¡', '.', ';', ':', ','], '', $texto);
        
        return trim($texto);
    }

    private function normalizarEstado(string $estado): string
    {
        $estado = strtolower($estado);
        if (str_contains($estado, 'capital') || str_contains($estado, 'caracas') || str_contains($estado, 'federal')) {
            return 'Distrito Capital';
        }
        
        $estados = ['amazonas', 'anzoategui', 'apure', 'aragua', 'barinas', 'bolivar', 'carabobo', 'cojedes', 'delta amacuro', 'falcon', 'guarico', 'lara', 'merida', 'miranda', 'monagas', 'nueva esparta', 'portuguesa', 'sucre', 'tachira', 'trujillo', 'vargas', 'yaracuy', 'zulia'];
        
        $estadoSinAcentos = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ä', 'ë', 'ï', 'ö', 'ü'],
            ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'],
            $estado
        );

        foreach ($estados as $est) {
            if (str_contains($estadoSinAcentos, $est)) {
                return ucfirst($est);
            }
        }

        return ucfirst($estado);
    }
}
