<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatbotPreguntaSinRespuestaController extends Controller
{
    public function index()
    {
        $preguntas = \App\Models\ChatbotPreguntaSinRespuesta::orderBy('id', 'desc')->paginate(15);
        return view('admin.chatbot.preguntas_sin_respuesta.index', compact('preguntas'));
    }

    public function destroy(\App\Models\ChatbotPreguntaSinRespuesta $preguntas_sin_respuestum)
    {
        $preguntas_sin_respuestum->delete();
        return redirect()->route('admin.chatbot.preguntas-sin-respuesta.index')
            ->with('success', 'Pregunta sin respuesta eliminada correctamente.');
    }
}
