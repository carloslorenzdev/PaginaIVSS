<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Http\Controllers\Controller;
use App\Jobs\Telegram\EnviaCodigoOTPTask;
use App\Models\User;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TelegramService;
use App\Services\Auth\TwoFactorAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorAuthController extends Controller
{
    /**
     * Vista para seleccionar metodo de 2fa
     */
    public function metodo(Request $request): View|RedirectResponse
    {
        /** @var User */
        $usuario = $request->user();
        $metodosSeleccionables = TwoFactorAuthService::userSelectableMethods($usuario->twoFactorAuthEnabled());
        if (count($metodosSeleccionables) && count($metodosSeleccionables) < 2) {
            // TIENE UN SOLO MÉTODO, REDIRIGE A VALIDAR CÓDIGO
            return redirect()->temporarySignedRoute(
                '2fa.verificar',
                now()->addMinutes(5),
                ['metodo' => $metodosSeleccionables[0]]
            );
        }
        $previous = $request->hasPreviousSession() ? $request->session()->previousUrl() : route('inicio');
        if ($previous == url()->current()) {
            $previous = route('inicio');
        }
        $authenticatorEnabled = AuthenticatorAppService::isEnabled();
        $telegramEnabled = TelegramService::isEnabled();
        $rutas[TwoFactorAuthenticatorEnum::AUTHENTICATOR->value] = url()->temporarySignedRoute(
            '2fa.verificar',
            now()->addMinutes(5),
            ['metodo' => TwoFactorAuthenticatorEnum::AUTHENTICATOR]
        );
        $rutas[TwoFactorAuthenticatorEnum::TELEGRAM->value] = url()->temporarySignedRoute(
            '2fa.verificar',
            now()->addMinutes(5),
            ['metodo' => TwoFactorAuthenticatorEnum::TELEGRAM]
        );
        return view(TwoFactorAuthService::VIEW_SELECT_METHOD, compact('previous', 'usuario', 'rutas', 'authenticatorEnabled', 'telegramEnabled'));
    }

    /**
     * Formulario para validar codigo segun método seleccionado
     */
    public function verificar(Request $request, TwoFactorAuthenticatorEnum $metodo): View|RedirectResponse
    {
        abort_if($metodo == TwoFactorAuthenticatorEnum::CORREO_ELECTRONICO, 404);
        /** @var User */
        $user = $request->user();
        TwoFactorAuthService::saveMethod($metodo);
        $previous = TwoFactorAuthService::getRoute() ?: route('inicio');
        if ($previous == url()->current()) {
            $previous = route('inicio');
        }
        $seleccionables = TwoFactorAuthService::userSelectableMethods($user->twoFactorAuthEnabled());
        $ruta = url()->temporarySignedRoute('2fa.verificar', now()->addMinutes(5), ['metodo' => $metodo]);
        $codigo = false;
        if ($metodo == TwoFactorAuthenticatorEnum::TELEGRAM) {
            if (!$user->telegram2faEnabled()) {
                return back()->withAlert(['danger', [
                    'mensaje' => 'Método no activo',
                    'ayuda' => 'Debes tener el método de TELEGRAM APP activo',
                    'acciones' => [
                        [
                            'descripcion' => 'Activar',
                            'ruta' => route('perfil.2fa.telegram-app.configuracion'),
                        ]
                    ]
                ]]);
            }
            $metodo = 'Telegram App';
            $icono = 'bxl-telegram';
            $codigo = true;
            $throttleKey = TelegramService::throttleKeySendOtp($user);
            if (TwoFactorAuthService::isConfirmedOtpExpired() && !TwoFactorAuthService::tooManyAttempts($throttleKey, 5)) {
                TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
                EnviaCodigoOTPTask::dispatch($user);
            }
        } else {
            if (!$user->google2faEnabled()) {
                return back()->withAlert(['danger', [
                    'mensaje' => 'Método no activo',
                    'ayuda' => 'Debes tener el método de AUTHENTICATOR APP activo',
                    'acciones' => [
                        [
                            'descripcion' => 'Activar',
                            'ruta' => route('perfil.2fa.authenticator-app.configuracion'),
                        ]
                    ]
                ]]);
            }
            $metodo = 'Authenticator App';
            $icono = 'bx-shield';
        }
        return view(TwoFactorAuthService::VIEW_VERIFY, compact('icono', 'metodo', 'previous', 'ruta', 'user', 'codigo', 'seleccionables'));
    }

    /**
     * POST para validar codigo OTP
     */
    public function verifyOtp(Request $request, TwoFactorAuthenticatorEnum $metodo): RedirectResponse
    {
        abort_if($metodo == TwoFactorAuthenticatorEnum::CORREO_ELECTRONICO, 404);
        /** @var User */
        $user = $request->user();

        $throttleKey = TelegramService::throttleKeyFailValidateOtp($user);
        TwoFactorAuthService::ensureValidatedOtpIsNotRateLimited($throttleKey);

        $codigo = collect($request->input('otp'))->join('');
        $valid = false;

        if ($metodo == TwoFactorAuthenticatorEnum::AUTHENTICATOR) {
            $valid = AuthenticatorAppService::validaCodigoOtpUsuario($user, $codigo);
        } else {
            $valid = TelegramService::validaCodigoOtp($user, $codigo);
        }

        if (!$valid) {
            TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
            throw ValidationException::withMessages([
                config('google2fa.otp_input') => 'Código OTP incorrecto',
            ]);
        }

        TwoFactorAuthService::saveConfirmed();
        TwoFactorAuthService::clearRateLimitedOtp($throttleKey);

        if ($request->boolean('remember_device')) {
            TwoFactorAuthService::rememberDevice($user);
        }

        return redirect()->intended(TwoFactorAuthService::getRoute());
    }
}
