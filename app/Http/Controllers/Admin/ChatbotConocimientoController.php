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
        $conocimientos = ChatbotConocimiento::orderBy('id', 'desc')->paginate(15);
        return view('admin.chatbot.conocimiento.index', compact('conocimientos'));
    }

    public function store(Request $request, CrearConocimientoAction $action)
    {
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
        $action->execute($conocimiento);
        return redirect()->route('admin.chatbot.conocimiento.index')
            ->with('success', 'Conocimiento eliminado exitosamente.');
    }
}
