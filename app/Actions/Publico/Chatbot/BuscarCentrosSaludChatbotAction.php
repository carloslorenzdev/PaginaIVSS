<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Directorio;

class BuscarCentrosSaludChatbotAction
{
    public function __construct(
        protected ResolverEstadoAction $resolverEstado
    ) {}

    public function esConsultaCentroSalud(string $mensaje): bool
    {
        $texto = $this->resolverEstado->normalizarTexto($mensaje);
        
        $palabras = [
            'hospital', 
            'clinica', 
            'ambulatorio', 
            'centro de salud', 
            'centros de salud', 
            'emergencia', 
            'hemodialisis', 
            'dialisis'
        ];

        foreach ($palabras as $p) {
            if (str_contains($texto, $p)) {
                return true;
            }
        }

        return false;
    }

    public function execute(string $mensaje): string
    {
        $estadoDetectado = $this->resolverEstado->detectarEstadoEnTexto($mensaje);

        if ($estadoDetectado) {
            $centros = Directorio::centrosSalud()
                ->where(function ($q) use ($estadoDetectado) {
                    $q->where('estado', 'LIKE', "%$estadoDetectado%")
                      ->orWhere('direccion', 'LIKE', "%$estadoDetectado%");
                })
                ->take(3)
                ->get();

            if ($centros->count() > 0) {
                $html = "<b>Centros de Salud encontrados en {$estadoDetectado}:</b><br><br>";
                foreach ($centros as $c) {
                    $html .= "<i class=\"fas fa-hospital text-primary\"></i> <b>{$c->nombre}</b><br>";
                    $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$c->direccion} ({$c->estado})<br>";
                    if ($c->telefono) {
                        $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$c->telefono}<br>";
                    }
                    $html .= "<br>";
                }
                return $html;
            }

            return "Lo sentimos, no encontramos centros de salud registrados en el sistema para {$estadoDetectado}. Puedes escribir <b>'centros de salud en' seguido de otro estado</b> (Ejemplo: centros de salud en Distrito Capital o Miranda).";
        }

        return "Para consultar los centros asistenciales u hospitales del IVSS, por favor escribe <b>'centros de salud en' seguido de tu estado</b> (Ejemplo: centros de salud en Distrito Capital, Carabobo o Zulia).";
    }
}
