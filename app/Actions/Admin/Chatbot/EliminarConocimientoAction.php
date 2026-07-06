<?php

namespace App\Actions\Admin\Chatbot;

use App\Models\ChatbotConocimiento;

class EliminarConocimientoAction
{
    public function execute(ChatbotConocimiento $conocimiento): bool
    {
        return $conocimiento->delete();
    }
}
