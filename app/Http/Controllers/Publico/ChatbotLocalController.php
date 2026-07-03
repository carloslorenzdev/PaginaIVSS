<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Publico\Chatbot\ProcesarMensajeChatbotAction;

class ChatbotLocalController extends Controller
{
    public function chat(Request $request, ProcesarMensajeChatbotAction $action)
    {
        $mensaje = $request->input('mensaje', '');
        
        $respuesta = $action->execute($mensaje);

        return response()->json([
            'respuesta' => $respuesta
        ]);
    }
}
