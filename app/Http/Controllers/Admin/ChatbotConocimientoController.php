<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotConocimiento;
use Illuminate\Http\Request;

use App\Actions\Admin\Chatbot\CrearConocimientoAction;
use App\Actions\Admin\Chatbot\ActualizarConocimientoAction;
use App\Actions\Admin\Chatbot\EliminarConocimientoAction;

class ChatbotConocimientoController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.ver'), 403, 'Acceso Denegado');
        $conocimientos = ChatbotConocimiento::orderBy('id', 'desc')->paginate(15);
        return view('admin.chatbot.conocimiento.index', compact('conocimientos'));
    }

    public function store(Request $request, CrearConocimientoAction $action)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.crear'), 403, 'Acceso Denegado');
        $request->validate([
            'pregunta' => 'required|string|max:255',
            'palabras_clave' => 'required|string|max:255',
            'respuesta' => 'required|string',
            'activo' => 'boolean',
        ]);

        $action->execute($request->all());

        return redirect()->route('admin.chatbot.conocimiento.index')
            ->with('success', 'Conocimiento agregado exitosamente.');
    }

    public function update(Request $request, ChatbotConocimiento $conocimiento, ActualizarConocimientoAction $action)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.editar'), 403, 'Acceso Denegado');
        $request->validate([
            'pregunta' => 'required|string|max:255',
            'palabras_clave' => 'required|string|max:255',
            'respuesta' => 'required|string',
            'activo' => 'boolean',
        ]);

        $action->execute($conocimiento, $request->all());

        return redirect()->route('admin.chatbot.conocimiento.index')
            ->with('success', 'Conocimiento actualizado exitosamente.');
    }

    public function destroy(ChatbotConocimiento $conocimiento, EliminarConocimientoAction $action)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.eliminar'), 403, 'Acceso Denegado');
        $action->execute($conocimiento);
        return redirect()->route('admin.chatbot.conocimiento.index')
            ->with('success', 'Conocimiento eliminado exitosamente.');
    }
}
