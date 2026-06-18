<?php

namespace App\Actions\Admin\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ActualizarUsuarioAction
{
    public function execute(User $usuario, array $data)
    {
        $usuario->name = $data['name'];
        $usuario->usuario = $data['usuario'];
        $usuario->email = $data['email'];
        $usuario->rol = $data['rol'];

        if (isset($data['activo'])) {
            $usuario->activo = $data['activo'] == '1';
        }

        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }

        $usuario->save();

        return $usuario;
    }
}
