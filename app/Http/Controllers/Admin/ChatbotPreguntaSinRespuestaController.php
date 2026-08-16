<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatbotPreguntaSinRespuestaController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.ver'), 403, 'Acceso Denegado');
        $preguntas = \App\Models\ChatbotPreguntaSinRespuesta::orderBy('id', 'desc')->paginate(15);
        return view('admin.chatbot.preguntas_sin_respuesta.index', compact('preguntas'));
    }

    public function destroy(\App\Models\ChatbotPreguntaSinRespuesta $preguntas_sin_respuestum)
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.eliminar'), 403, 'Acceso Denegado');
        $preguntas_sin_respuestum->delete();
        return redirect()->route('admin.chatbot.preguntas-sin-respuesta.index')
            ->with('success', 'Pregunta sin respuesta eliminada correctamente.');
    }
}
