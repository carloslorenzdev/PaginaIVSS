<?php

namespace App\Http\Middleware;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Services\Auth\TelegramService;
use App\Services\Auth\TwoFactorAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Valida que tenga las variables se sesion para Auth y OTP. También que no esté expirada
 */
class TwoFactorAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        if (TwoFactorAuthService::isEnabled() && $request->user()->hasEnabled2fa()) {
            if (TwoFactorAuthService::isDeviceRemembered($request->user())) {
                return $next($request);
            }
            // METODOS DISPONIBLES CON LOS QUE EL USUARIO TIENE ACTIVOS
            $metodosSeleccionables = TwoFactorAuthService::userSelectableMethods($request->user()->twoFactorAuthEnabled());
            if (count($metodosSeleccionables)) {
                // HAY METODO DISPONIBLE Y EL USUARIO TIENE ACTIVO ESE MÉTODO
                if (!TwoFactorAuthService::getConfirmedAuth()) {
                    // VALIDAMOS SI EXISTE CLAVE PENDIENTE DE ACTIVACIÓN TELEGRAM
                    if (TelegramService::getKeyActivacion($request->user())) {
                        TwoFactorAuthService::setAllKeysSession(TwoFactorAuthenticatorEnum::TELEGRAM);
                        TelegramService::deleteKeyActivacion($request->user());
                    } else {
                        // AUTHENTICACIÓN
                        TwoFactorAuthService::resetSessionAuth();
                        TwoFactorAuthService::saveTipo2fa($tipo);
                        TwoFactorAuthService::saveRoute($request->getPathInfo());
                        return redirect(url()->temporarySignedRoute('2fa.selecciona-metodo', now()->addMinutes(10)));
                    }
                } else if ($tipo == 'otp') {
                    TwoFactorAuthService::saveTipo2fa($tipo);
                    // OTP
                    if (!TwoFactorAuthService::getConfirmedOtp() || TwoFactorAuthService::isConfirmedOtpExpired()) {
                        TwoFactorAuthService::resetSessionOtp();
                        TwoFactorAuthService::saveRoute($request->getPathInfo());
                        return redirect(url()->temporarySignedRoute('2fa.selecciona-metodo', now()->addMinutes(10)));
                    }
                }
            }
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
