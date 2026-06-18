<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\Admin\Usuarios\ActualizarUsuarioAction;
use Illuminate\Validation\Rule;

class ActualizarUsuarioController extends Controller
{
    public function __invoke(Request $request, $id, ActualizarUsuarioAction $action)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'usuario' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => ['required', Rule::in(['admin', 'prensa_redactor', 'prensa_aprobador'])],
            'activo' => 'required|boolean',
        ]);

        $action->execute($usuario, $validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }
}
