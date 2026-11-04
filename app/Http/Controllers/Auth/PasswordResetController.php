<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SesionUsuario;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TwoFactorAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
     * Paso 1: Identificación sin enumeración de usuarios (CWE-204)
     * Responde siempre con un mensaje genérico idéntico tanto si el usuario existe como si no.
     */
    public function verificarUsuario(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => ['required', 'string', 'max:50'],
        ]);

        // No revelamos si el usuario existe o no para prevenir enumeración (CWE-204)
        return response()->json([
            'success' => true,
            'has_2fa' => true,
            'message' => 'Si los datos son válidos y la cuenta posee 2FA configurado, ingrese el código OTP de su aplicación autenticadora.'
        ]);
    }

    /**
     * Paso 2: Verificar el código 2FA y emitir un token firmado de un solo uso (CWE-307)
     */
    public function verificarCodigo(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => ['required', 'string', 'max:50'],
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('usuario', $request->usuario)->first();

        // Si el usuario no existe o no tiene 2FA, rechazamos con mensaje genérico
        if (!$user || !$user->google2faEnabled()) {
            return response()->json([
                'success' => false,
                'message' => 'No fue posible validar la autenticación con los datos suministrados.'
            ], 400);
        }

        if (!AuthenticatorAppService::validaCodigoOtpUsuario($user, $request->codigo)) {
            Log::warning("Intento fallido de recuperación 2FA para usuario: {$user->usuario}", [
                'ip' => $request->ip()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'El código OTP es incorrecto o ha expirado.'
            ], 400);
        }

        // Generar un token criptográfico de recuperación firmado de un solo uso (10 min de validez)
        $resetToken = Str::random(64);
        Cache::put('pwd_reset_token:' . $resetToken, $user->id, now()->addMinutes(10));

        return response()->json([
            'success' => true,
            'reset_token' => $resetToken,
            'message' => 'Código 2FA verificado correctamente.'
        ]);
    }

    /**
     * Paso 3: Restablecer contraseña exigiendo el token firmado de un solo uso (CWE-307 / CWE-613)
     */
    public function restablecer(Request $request): JsonResponse
    {
        $request->validate([
            'reset_token' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Consumir el token (de un solo uso)
        $userId = Cache::pull('pwd_reset_token:' . $request->reset_token);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'La sesión o el token de recuperación ha expirado. Por favor inicie el proceso nuevamente.'
            ], 400);
        }

        $user = User::findOrFail($userId);

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        // 1. Invalidar todas las sesiones activas del usuario (CWE-613)
        try {
            SesionUsuario::where('created_by', $user->id)
                ->whereNull('logout')
                ->update(['logout' => now()]);
        } catch (\Exception $e) {
            Log::error('Error invalidando sesiones previas en reset de password: ' . $e->getMessage());
        }

        // 2. Revocar token y cookie remember_2fa (CWE-613)
        TwoFactorAuthService::forgetRememberDevice($user);

        // 3. Auditoría de seguridad
        if (function_exists('activity')) {
            activity('seguridad')
                ->causedBy($user)
                ->performedOn($user)
                ->log("Contraseña restablecida exitosamente mediante verificación 2FA desde IP: {$request->ip()}");
        }

        return response()->json([
            'success' => true,
            'message' => 'Contraseña restablecida exitosamente. Ya puede iniciar sesión con su nueva clave.'
        ]);
    }
}
