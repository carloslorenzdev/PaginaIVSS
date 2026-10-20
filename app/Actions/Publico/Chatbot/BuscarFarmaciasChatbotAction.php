<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\Directorio;

class BuscarFarmaciasChatbotAction
{
    public function __construct(
        protected ResolverEstadoAction $resolverEstado
    ) {}

    public function esConsultaFarmacia(string $mensaje): bool
    {
        $texto = $this->resolverEstado->normalizarTexto($mensaje);
        return str_contains($texto, 'farmacia');
    }

    public function execute(string $mensaje): string
    {
        $estadoDetectado = $this->resolverEstado->detectarEstadoEnTexto($mensaje);

        if ($estadoDetectado) {
            $farmacias = Directorio::farmacias()
                ->where(function ($q) use ($estadoDetectado) {
                    $q->where('estado', 'LIKE', "%$estadoDetectado%")
                      ->orWhere('direccion', 'LIKE', "%$estadoDetectado%");
                })
                ->take(3)
                ->get();

            if ($farmacias->count() > 0) {
                $html = "<b>Farmacias de Alto Costo encontradas en {$estadoDetectado}:</b><br><br>";
                foreach ($farmacias as $f) {
                    $html .= "<i class=\"fas fa-clinic-medical text-primary\"></i> <b>{$f->nombre}</b><br>";
                    $html .= "<i class=\"fas fa-map-marker-alt text-danger\"></i> {$f->direccion} ({$f->estado})<br>";
                    if ($f->telefono) {
                        $html .= "<i class=\"fas fa-phone-alt text-success\"></i> {$f->telefono}<br>";
                    }
                    $html .= "<br>";
                }
                return $html;
            }

            return "Lo sentimos, no encontramos farmacias de alto costo registradas para {$estadoDetectado} en este momento. Puedes comunicarte a la línea de atención 0800-IVSS para mayor orientación.";
        }

        return "Para indicarte las Farmacias de Alto Costo disponibles, por favor escribe <b>'farmacias en' seguido de tu estado</b> (Ejemplo: farmacias en Miranda, Aragua o Distrito Capital).";
    }
}
