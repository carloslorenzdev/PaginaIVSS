<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Admin\Usuarios\GuardarUsuarioAction;
use Illuminate\Validation\Rule;

class GuardarUsuarioController extends Controller
{
    public function __invoke(Request $request, GuardarUsuarioAction $action)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => ['required', Rule::in(['admin', 'prensa_redactor', 'prensa_aprobador'])],
        ]);

        $action->execute($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
}
