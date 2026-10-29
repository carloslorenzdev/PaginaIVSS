<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\RegistrarUsuarioRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
class RegistrarUsuarioController extends Controller
{
    /**
     * Post para registrar usuario
     */
    public function crear(RegistrarUsuarioRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            
            // USUARIO
            $user = User::create([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'usuario' => $data['usuario'],
                'created_by' => $request->user()->id,
                'cambio_pass' => null, // Esto fuerza a que deba cambiarla
            ]);

            // ROL
            $user->assignRole($data['rol']);
            
            \App\Services\AuditoriaService::registrar(
                'creacion',
                "Registró al nuevo usuario '{$user->usuario}' ({$user->nombre}) con el rol: {$data['rol']}",
                $user,
                ['usuario' => $user->usuario, 'rol' => $data['rol'], 'email' => $user->email]
            );

            Log::channel('acciones')
                ->info('El usuario "' . $request->user()->usuario . '" ha registrado al usuario "' . $user->usuario . '" con el rol: ' . $data['rol']);
                
            // TODO: In a real app, send an email to the user with the $tempPassword here.
        });
        
        return to_route('usuarios.listado')->withAlert(['success', 'Usuario registrado correctamente']);
    }
}
