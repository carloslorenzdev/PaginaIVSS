<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Telegram\EnviaCodigoOTPTask;
use App\Models\User;
use App\Services\Auth\TelegramService;
use App\Services\Auth\TwoFactorAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class Telegram2faController extends Controller
{
    /**'
     * Vista de configuración
     */
    public function configuracion(Request $request): View
    {
        /** @var User */
        $user = $request->user();
        $enabled = TelegramService::isEnabled();
        $data = [];
        $botInfo = TelegramService::info();
        if ($enabled && !$user->telegram2faEnabled()) {
            $data = TelegramService::generaInfoActivacion($user);
        }
        $sesion = TwoFactorAuthService::getTelegramConfirmedAuth();
        $otp = TwoFactorAuthService::getTelegramConfirmedOtp();
        return view(config('telegram.view'), compact('user', 'data', 'enabled', 'botInfo', 'sesion', 'otp'));
    }

    /**
     * Envía código OTP al usuario autenticado
     */
    public function enviaOTP(Request $request): RedirectResponse
    {
        $throttleKey = TelegramService::throttleKeySendOtp($request->user());
        if (TwoFactorAuthService::isConfirmedOtpExpired() && !TwoFactorAuthService::tooManyAttempts($throttleKey, 5)) {
            TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
            EnviaCodigoOTPTask::dispatch($request->user());
            $alert = ['success', 'Código Temporal enviado'];
        } else {
            $alert = ['danger', 'Límite de envíos alcanzado, espere unos minutos'];
        }
        return back()->withAlert($alert);
    }

    /**
     * POST para Deshabilitar el método 2fa
     */
    public function deshabilitar(Request $request): RedirectResponse
    {
        $throttleKey = TelegramService::throttleKeyFailValidateOtp($request->user());
        TwoFactorAuthService::ensureValidatedOtpIsNotRateLimited($throttleKey);

        $codigo = collect($request->input('otp'))->join('');

        if (!TelegramService::validaCodigoOtp($request->user(), $codigo)) {
            TwoFactorAuthService::hitValidateOtp($throttleKey, 60 * 5);
            throw ValidationException::withMessages([
                config('google2fa.otp_input') => 'Código OTP incorrecto',
            ]);
        }

        TelegramService::desactivar($request->user());
        Log::channel('acciones')
            ->info('El usuario "' . $request->user()->usuario . '" ha desactivado el método 2FA de Telegram App');
        TwoFactorAuthService::clearRateLimitedOtp($throttleKey);

        return to_route('perfil.2fa.telegram-app.configuracion')
            ->withAlert([
                'success',
                ['mensaje' => '2FA desactivado', 'ayuda' => 'Método de 2FA por Telegram App se desactivó correctamente']
            ]);
    }
}
