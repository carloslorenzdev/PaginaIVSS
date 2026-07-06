<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\AuthenticatorAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Muestra la vista del wizard de recuperación
     */
    public function show(): View
    {
        return view('auth.recuperar-password');
    }

    /**
     * Paso 1: Verificar que el usuario exista y tenga 2FA habilitado
     */
    public function verificarUsuario(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => ['required', 'string'],
        ]);

        $user = User::where('usuario', $request->usuario)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        if (!$user->google2faEnabled()) {
            return response()->json([
                'success' => false,
                'has_2fa' => false,
                'message' => 'Hemos detectado que no posee habilitada en su cuenta la autenticacion 2fa, para la recuperacion de contraseña de su usuario pongase en contacto con el administrador del sistema.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'has_2fa' => true,
            'message' => 'Usuario verificado. Proceda a ingresar el código 2FA.'
        ]);
    }

    /**
     * Paso 2: Verificar el código 2FA
     */
    public function verificarCodigo(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => ['required', 'string'],
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('usuario', $request->usuario)->first();

        if (!$user || !$user->google2faEnabled()) {
            return response()->json(['success' => false, 'message' => 'Usuario inválido.'], 400);
        }

        if (!AuthenticatorAppService::validaCodigoOtpUsuario($user, $request->codigo)) {
            return response()->json(['success' => false, 'message' => 'Código OTP incorrecto.'], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Código verificado correctamente.'
        ]);
    }

    /**
     * Paso 3: Restablecer contraseña
     */
    public function restablecer(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => ['required', 'string'],
            'codigo' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('usuario', $request->usuario)->first();

        if (!$user || !$user->google2faEnabled()) {
            return response()->json(['success' => false, 'message' => 'Usuario inválido.'], 400);
        }

        // Re-validar el código por seguridad antes de cambiar la clave
        if (!AuthenticatorAppService::validaCodigoOtpUsuario($user, $request->codigo)) {
            return response()->json(['success' => false, 'message' => 'El código OTP ha expirado o es incorrecto.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña restablecida exitosamente.'
        ]);
    }
}
