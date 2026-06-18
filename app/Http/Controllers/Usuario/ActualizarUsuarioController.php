<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\ActualizarUsuarioRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class ActualizarUsuarioController extends Controller
{
    /**
     * Formulario para actualizar usuario
     */
    public function editar(Request $request, User $usuario): View
    {
        $this->authorize('update', $usuario);

        $roles = Role::where('name', '<>', 'Patrono')->orderBy('name');
        if (!$request->user()->isAdmin()) {
            $roles->orWhere('name', '<>', 'Admin');
        }
        $roles = $roles->get();

        return view('usuarios.editar', compact('usuario', 'roles'));
    }

    /**
     * POST para actualizar usuario
     */
    public function actualizar(ActualizarUsuarioRequest $request, User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        DB::transaction(function () use ($request, $usuario) {
            $data = $request->validated();
            
            // USUARIO
            $usuario->nombre = $data['nombre'];
            $usuario->email = $data['email'];
            if ($usuario->isDirty()) {
                $usuario->updated_by = $request->user()->id;
                if ($usuario->isDirty('email')) {
                    $usuario->email_verified_at = null;
                }
                $usuario->save();
                Log::channel('acciones')
                    ->info('El usuario "' . $request->user()->usuario . '" ha actualizado la información del usuario "' . $usuario->usuario . '"');
            }

            // ROL
            if (!$usuario->hasRole($data['rol'])) {
                $usuario->syncRoles($data['rol']);
                $usuario->updated_by = $request->user()->id;
                $usuario->save();
                Log::channel('acciones')
                    ->info('El usuario "' . $request->user()->usuario . '" ha cambiado el rol del usuario "' . $usuario->usuario . '" a: ' . $data['rol']);
            }

            // OBSERVACION
            if (!empty($data['observacion'])) {
                $usuario->observaciones()->create([
                    'observacion' => $data['observacion'],
                    'created_by' => $request->user()->id,
                ]);
            }
        });
        return to_route('usuarios.detalle', $usuario)->withAlert(['success', 'Usuario actualizado']);
    }
}
