<?php

namespace App\Actions\Admin\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuardarUsuarioAction
{
    public function execute(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'usuario' => $data['usuario'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => $data['rol'],
            'activo' => true,
        ]);
    }
}
