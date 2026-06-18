<?php

namespace App\Http\Middleware;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware que asegura que el usuario tenga activo el método 2FA según tipo
 */
class CheckUserHasTwoFactorActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        /** @var User */
        $user = $request->user();
        // AUTHENTICATOR APP
        if ($tipo == TwoFactorAuthenticatorEnum::AUTHENTICATOR->value && !$user->google2faEnabled()) {
            return back()->withAlert(['danger', [
                'mensaje' => 'Método no activo',
                'ayuda' => 'Debes tener el método de Authenticator App activo',
                'acciones' => [
                    [
                        'descripcion' => 'Activar',
                        'ruta' => route('perfil.2fa.authenticator-app.configuracion'),
                    ]
                ]
            ]]);
        }
        // TELEGRAM APP
        if ($tipo == TwoFactorAuthenticatorEnum::TELEGRAM->value && !$user->telegram2faEnabled()) {
            return back()->withAlert(['danger', [
                'mensaje' => 'Método no activo',
                'ayuda' => 'Debes tener el método de Telegram App activo',
                'acciones' => [
                    [
                        'descripcion' => 'Activar',
                        'ruta' => route('perfil.2fa.telegram-app.configuracion'),
                    ]
                ]
            ]]);
        }
        return $next($request);
    }
}
