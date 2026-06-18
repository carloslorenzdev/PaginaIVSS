<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TwoFactorAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class Authenticator2faController extends Controller
{
    /**'
     * Vista de configuración
     */
    public function configuracion(Request $request): View
    {
        /** @var User */
        $user = $request->user();
        $enabled = AuthenticatorAppService::isEnabled();
        $data = [];
        if ($enabled && !$user->google2faEnabled()) {
            $data = AuthenticatorAppService::generaInfoActivacion($user);
        }
        $sesion = TwoFactorAuthService::getAuthenticatorConfirmedAuth();
        $otp = TwoFactorAuthService::getAuthenticatorConfirmedOtp();
        return view(config('google2fa.view'), compact('user', 'data', 'enabled', 'sesion', 'otp'));
    }

    /**
     * POST para habilitar Authenticator app
     */
    public function habilitar(Request $request): RedirectResponse
    {
        /** @var User */
        $user = $request->user();
        $throttleKey = AuthenticatorAppService::throttleKeyFailValidateOtp($user);
        TwoFactorAuthService::ensureValidatedOtpIsNotRateLimited($throttleKey);

        if ($user->google2faEnabled()) {
            return to_route('perfil.2fa.authenticator-app.configuracion')
                ->withAlert([
                    'danger',
                    ['mensaje' => 'Authenticator App Activo', 'ayuda' => 'Ya tienes el Authenticator App Activo.']
                ]);
        }

        $data = AuthenticatorAppService::getInfoCodigoUsuario($user->id);

        if (!$data || !array_key_exists('clave', $data)) {
            return to_route('perfil.2fa.authenticator-app.configuracion')
                ->withAlert(['danger', 'Clave Secreta 2FA no encontrada. Intenta de nuevo.']);
        }

        $codigo = collect($request->input('otp'))->join('');

        if (!AuthenticatorAppService::validaCodigoOtp($data['clave'], $codigo)) {
            TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
            throw ValidationException::withMessages([
                config('google2fa.otp_input') => 'Código OTP incorrecto',
            ]);
        }

        // HABILITA MÉTODO
        AuthenticatorAppService::activar($user, $data['clave']);
        cache()->forget($user->id . AuthenticatorAppService::TWO_FACTOR_INFO_TEMP);
        TwoFactorAuthService::setAllKeysSession(TwoFactorAuthenticatorEnum::AUTHENTICATOR);
        Log::channel('acciones')->info('El usuario "' . $user->usuario . '" ha activado el método 2FA de Authenticator App');
        TwoFactorAuthService::clearRateLimitedOtp($throttleKey);

        return to_route('perfil.2fa.authenticator-app.configuracion')
            ->withAlert([
                'success',
                ['mensaje' => '2FA activado', 'ayuda' => 'Método de 2FA por Authenticator App se activó correctamente']
            ]);
    }

    /**
     * POST para deshabilitar Authenticator App
     */
    public function deshabilitar(Request $request): RedirectResponse
    {
        /** @var User */
        $user = $request->user();
        $throttleKey = AuthenticatorAppService::throttleKeyFailValidateOtp($user);
        TwoFactorAuthService::ensureValidatedOtpIsNotRateLimited($throttleKey);
        $codigo = collect($request->input('otp'))->join('');

        if (!AuthenticatorAppService::validaCodigoOtpUsuario($user, $codigo)) {
            TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
            throw ValidationException::withMessages([
                config('google2fa.otp_input') => 'Código OTP incorrecto',
            ]);
        }

        // DESHABILITA MÉTODO
        AuthenticatorAppService::desactivar($user);
        Log::channel('acciones')->info('El usuario "' . $user->usuario . '" ha desactivado el método 2FA de Authenticator App');
        TwoFactorAuthService::clearRateLimitedOtp($throttleKey);

        return to_route('perfil.2fa.authenticator-app.configuracion')
            ->withAlert([
                'success',
                ['mensaje' => '2FA desactivado', 'ayuda' => 'Método de 2FA por Authenticator App se desactivó correctamente']
            ]);
    }
}
