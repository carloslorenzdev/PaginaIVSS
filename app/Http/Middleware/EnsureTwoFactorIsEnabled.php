<?php

namespace App\Http\Middleware;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TelegramService;
use App\Services\Auth\TwoFactorAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Valida que TODOS o ALGÚN servicio de 2FA esté disponible (.env). También recibe argumento para tipo de servicio
 */
class EnsureTwoFactorIsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $tipo = 'todos'): Response
    {
        if ($tipo == 'todos') {
            // VALIDA QUE ALGUNO ESTE DISPONIBLE
            if (!TwoFactorAuthService::isEnabled()) {
                return to_route('inicio')->withAlert(['danger', [
                    'mensaje' => '2FA no disponible',
                    'ayuda' => 'Servicio 2FA no está disponible, regrese más tarde',
                ]]);
            }
        }
        if ($tipo == 'metodo') {
            // ESTA EN RUTA VERIFICAR CÓDIGO
            $tipo = $request->metodo->value;
        }
        if ($tipo == TwoFactorAuthenticatorEnum::AUTHENTICATOR->value) {
            // VALIDA QUE EL SERVICIO DE AUTHENTICATOR ESTE DISPONIBLE
            if (!AuthenticatorAppService::isEnabled()) {
                return to_route('inicio')->withAlert(['danger', [
                    'mensaje' => 'Authenticator App no disponible',
                    'ayuda' => 'Servicio Authenticator App no está disponible, regrese más tarde',
                ]]);
            }
        }
        if ($tipo == TwoFactorAuthenticatorEnum::TELEGRAM->value) {
            // VALIDA QUE EL SERVICIO DE TELEGRAM ESTE DISPONIBLE
            if (!TelegramService::isEnabled()) {
                return to_route('inicio')->withAlert(['danger', [
                    'mensaje' => 'Telegram App no disponible',
                    'ayuda' => 'Servicio Telegram App no está disponible, regrese más tarde',
                ]]);
            }
        }
        return $next($request);
    }
}
