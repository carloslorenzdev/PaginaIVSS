<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginUsuarioAction
{
    public function execute(array $credentials)
    {
        $user = User::where('usuario', $credentials['usuario'])->first();

        if ($user && Hash::check($credentials['contrasena'], $user->password)) {
            Auth::login($user);
            return true;
        }

        return false;
    }
}
