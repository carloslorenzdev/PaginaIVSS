<?php

namespace App\Actions\Admin\Chatbot;

use App\Models\ChatbotConocimiento;

class CrearConocimientoAction
{
    public function execute(array $data): ChatbotConocimiento
    {
        return ChatbotConocimiento::create([
            'pregunta' => $data['pregunta'],
            'palabras_clave' => strtolower($data['palabras_clave']),
            'respuesta' => $data['respuesta'],
            'activo' => isset($data['activo']) ? (bool) $data['activo'] : false,
        ]);
    }
}
