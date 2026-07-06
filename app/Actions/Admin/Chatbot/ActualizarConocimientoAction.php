<?php

namespace App\Actions\Admin\Chatbot;

use App\Models\ChatbotConocimiento;

class ActualizarConocimientoAction
{
    public function execute(ChatbotConocimiento $conocimiento, array $data): ChatbotConocimiento
    {
        $conocimiento->update([
            'pregunta' => $data['pregunta'],
            'palabras_clave' => strtolower($data['palabras_clave']),
            'respuesta' => $data['respuesta'],
            'activo' => isset($data['activo']) ? (bool) $data['activo'] : false,
        ]);

        return $conocimiento;
    }
}
