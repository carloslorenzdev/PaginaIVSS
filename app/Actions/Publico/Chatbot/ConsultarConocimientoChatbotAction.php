<?php

namespace App\Actions\Publico\Chatbot;

use App\Models\ChatbotConocimiento;
use App\Models\ChatbotPreguntaSinRespuesta;
use Illuminate\Support\Str;

class ConsultarConocimientoChatbotAction
{
    public function execute(string $mensajeOriginal): string
    {
        $mensajeLimpio = $this->normalizarTexto($mensajeOriginal);
        $conocimientos = ChatbotConocimiento::activos()->get();
        
        $mejorConocimiento = null;
        $maxPuntaje = 0;

        foreach ($conocimientos as $conocimiento) {
            $palabrasClaveOriginales = array_map('trim', explode(',', $conocimiento->palabras_clave ?? ''));
            $palabrasClave = [];

            foreach ($palabrasClaveOriginales as $p) {
                $pLimpia = $this->normalizarTexto($p);
                if (!empty($pLimpia)) {
                    $palabrasClave[] = $pLimpia;
                }
            }

            // También consideramos la pregunta cargada como frase clave
            $preguntaLimpia = $this->normalizarTexto($conocimiento->pregunta ?? '');
            if (!empty($preguntaLimpia) && !in_array($preguntaLimpia, $palabrasClave)) {
                $palabrasClave[] = $preguntaLimpia;
            }

            $puntaje = 0;

            foreach ($palabrasClave as $palabra) {
                if (!empty($palabra) && str_contains($mensajeLimpio, $palabra)) {
                    $puntaje += mb_strlen($palabra);
                }
            }

            if ($puntaje > $maxPuntaje) {
                $maxPuntaje = $puntaje;
                $mejorConocimiento = $conocimiento;
            }
        }

        if ($mejorConocimiento && $maxPuntaje > 0) {
            return nl2br($mejorConocimiento->respuesta);
        }

        // Registrar pregunta sin respuesta si no existe previamente y tiene longitud razonable (CWE-770)
        $preguntaLimpia = \Illuminate\Support\Str::limit(trim($mensajeOriginal), 250);
        if (mb_strlen($preguntaLimpia) >= 4 && mb_strlen($preguntaLimpia) <= 250) {
            $totalSinRespuesta = ChatbotPreguntaSinRespuesta::count();
            if ($totalSinRespuesta < 3000) {
                $existe = ChatbotPreguntaSinRespuesta::where('pregunta', $preguntaLimpia)->exists();
                if (!$existe) {
                    ChatbotPreguntaSinRespuesta::create([
                        'pregunta' => $preguntaLimpia
                    ]);
                }
            }
        }

        return 'Lo siento, soy un Asistente del IVSS configurado exclusivamente para orientación de trámites y consultas institucionales. No cuento con IA externa ni conexión a Internet abierta para responder a esa solicitud. ¿Te puedo ayudar buscando alguna farmacia, centro de salud, trámite de RRHH o del Sistema Tiuna?';
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = Str::ascii(Str::lower(trim($texto)));
        return str_replace(['?', '¿', '!', '¡', '.', ';', ':', ','], '', $texto);
    }
}
