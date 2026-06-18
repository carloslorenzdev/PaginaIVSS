<?php

namespace App\Services\Auth;

use App\Enums\TwoFactorAuthenticatorEnum;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class TwoFactorAuthService
{
    /**
     * Vista para seleccionar método de 2fa
     */
    public const VIEW_SELECT_METHOD = 'auth.select-otp';

    /**
     * Vista para la verificación del código OTP
     */
    public const VIEW_VERIFY = 'auth.verify-otp';

    /**
     * Key para tipo de verificacion (auth/otp) viene del middleware
     */
    public const KEY_TIPO_MIDDLEWARE = 'two_factor_tipo_middleware';

    /**
     * Variable de sesion para método de la autenticación
     */
    public const KEY_AUTH_METHOD = 'auth.method';

    /**
     * Variable de sesion para tiempo de confirmación de la autenticación ESTE NO VENCE
     */
    public const KEY_AUTH_CONFIRMED = 'auth.confirmed_at';

    /**
     * Variable de sesion para ruta redirección (INTENDED) luego de verificar 2fa
     */
    public const KEY_AUTH_ROUTE = 'auth.route';

    /**
     * Variable de sesion para método de OTP
     */
    public const KEY_OTP_METHOD = 'otp.method';

    /**
     * Variable de sesion para tiempo de confirmación del OTP
     */
    public const KEY_OTP_CONFIRMED = 'otp.confirmed_at';

    /**
     * Variable de sesion para ruta redirección (INTENDED) luego de verificar 2fa
     */
    public const KEY_OTP_ROUTE = 'otp.route';

    /**
     * Valida que algun servicio de 2FA este activo
     */
    public static function isEnabled(): bool
    {
        return (bool) AuthenticatorAppService::isEnabled() || (bool) TelegramService::isEnabled();
    }

    /**
     * Servicios disponibles de 2fa (.env)
     */
    public static function availableServices(): array
    {
        $servicios = [];
        if (AuthenticatorAppService::isEnabled()) {
            $servicios[] = TwoFactorAuthenticatorEnum::AUTHENTICATOR->value;
        }
        if (TelegramService::isEnabled()) {
            $servicios[] = TwoFactorAuthenticatorEnum::TELEGRAM->value;
        }
        return $servicios;
    }

    /**
     * Servicios disponibles de 2fa segun el usuario tiene activos
     */
    public static function userSelectableMethods(array $twoFactorUserEnabled): array
    {
        $servicios = [];
        foreach (self::availableServices() as $metodo2fa) {
            if (in_array($metodo2fa, $twoFactorUserEnabled)) {
                $servicios[] = $metodo2fa;
            }
        }
        return $servicios;
    }

    /**
     * Obtiene el valor de la variable guardada en sesion
     */
    public static function getSession(string $key): mixed
    {
        return request()->session()->get($key);
    }

    /**
     * Guarda el valor de la variable en sesion
     */
    public static function saveSession(string $key, mixed $value = null)
    {
        request()->session()->put($key, $value);
    }

    /**
     * Elimina la variable en sesion
     */
    public static function deleteSession(string $key)
    {
        request()->session()->forget($key);
    }

    /**
     * Verifica si existe la variable guardada en sesion
     */
    public static function existsSession(string $key): bool
    {
        return request()->session()->exists($key);
    }

    /**
     * Guarda el tipo de verificación 2fa
     */
    public static function saveTipo2fa(string $tipo)
    {
        self::saveSession(self::KEY_TIPO_MIDDLEWARE, $tipo);
    }

    /**
     * Obtiene el tipo de verificación 2fa
     */
    public static function getTipo2fa(): string
    {
        return self::getSession(self::KEY_TIPO_MIDDLEWARE);
    }

    /**
     * Elimina de la sesion el tipo de verificación 2fa
     */
    public static function deleteTipo2fa()
    {
        self::deleteSession(self::KEY_TIPO_MIDDLEWARE);
    }

    /**
     * Setea variables de sesion cuando usuario activa algun 2fa
     */
    public static function setAllKeysSession(TwoFactorAuthenticatorEnum $metodo)
    {
        if (!self::getConfirmedAuth()) {
            self::resetSessionAuth();
            self::saveTipo2fa('auth');
            self::saveMethod($metodo);
            self::saveConfirmedAuth();
        }
        self::resetSessionOtp();
        self::saveTipo2fa('otp');
        self::saveMethod($metodo);
        self::saveConfirmedOtp();
    }

    /**
     * Valida si llegó al limite de intentos validacion OTP
     */
    public static function tooManyAttempts(string $throttleKey, int $limiteIntentos = 5): bool
    {
        return RateLimiter::tooManyAttempts($throttleKey, $limiteIntentos);
    }

    /**
     * Asegura que no halla llegado al limite de intentos fallidos
     */
    public static function ensureValidatedOtpIsNotRateLimited(string $throttleKey, int $limite = 5): null|ValidationException
    {
        if (!self::tooManyAttempts($throttleKey, $limite)) {
            return null;
        }
        // SE PUEDE COLOCAR EVENTO AQUI
        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            config('google2fa.otp_input') => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Agrega 1 intento para fallo al validar codigo OTP o para enviarlo
     */
    public static function hitValidateOtp(string $throttleKey, int $ttl = 60)
    {
        RateLimiter::hit($throttleKey, $ttl);
    }

    /**
     * Elimina ThrottleKey del rate limited
     */
    public static function clearRateLimitedOtp(string $throttleKey)
    {
        RateLimiter::clear($throttleKey);
    }

    /**
     * Reinicia variables de sesion para AUTH
     */
    public static function resetSessionAuth()
    {
        self::saveSession(self::KEY_AUTH_METHOD, null);
        self::saveSession(self::KEY_AUTH_CONFIRMED, null);
        self::saveSession(self::KEY_AUTH_ROUTE, null);
    }

    /**
     * Reinicia variables de sesion para OTP
     */
    public static function resetSessionOtp()
    {
        self::saveSession(self::KEY_OTP_METHOD, null);
        self::saveSession(self::KEY_OTP_CONFIRMED, null);
        self::saveSession(self::KEY_OTP_ROUTE, null);
    }

    /**
     * Guarda ruta para ambos segun tipo
     */
    public static function saveRoute(string|null $route)
    {
        if (request()->routeIs('2fa.*')) {
            $route = route('inicio');
        }
        if (self::getTipo2fa() == 'auth') {
            // AUTH
            self::saveSession(self::KEY_AUTH_ROUTE, $route);
        } else {
            // OTP
            self::saveSession(self::KEY_OTP_ROUTE, $route);
        }
    }

    /**
     * Obtiene ruta para ambos segun tipo
     */
    public static function getRoute(): string|null
    {
        if (self::getTipo2fa() == 'auth') {
            return self::getSession(self::KEY_AUTH_ROUTE);
        } else {
            return self::getSession(self::KEY_OTP_ROUTE);
        }
    }

    /**
     * Guarda para ambos el metodo seleccionado por el usuario
     */
    public static function saveMethod(TwoFactorAuthenticatorEnum $method)
    {
        if (self::getTipo2fa() == 'auth') {
            // AUTH
            self::saveSession(self::KEY_AUTH_METHOD, $method->value);
        } else {
            // OTP
            self::saveSession(self::KEY_OTP_METHOD, $method->value);
        }
    }

    /**
     * Obtiene para ambos el metodo seleccionado por el usuario
     */
    public static function getMethod()
    {
        if (self::getTipo2fa() == 'auth') {
            // AUTH
            self::getSession(self::KEY_AUTH_METHOD);
        } else {
            // OTP
            self::getSession(self::KEY_OTP_METHOD);
        }
    }

    /**
     * Guarda confirmacion para AUTH
     */
    public static function saveConfirmedAuth()
    {
        self::saveSession(self::KEY_AUTH_CONFIRMED, time());
    }

    /**
     * Obtiene confirmacion para AUTH
     */
    public static function getConfirmedAuth(): int
    {
        return (int) self::getSession(self::KEY_AUTH_CONFIRMED);
    }

    /**
     * Guarda confirmacion para OTP
     */
    public static function saveConfirmedOtp()
    {
        self::saveSession(self::KEY_OTP_CONFIRMED, time());
        self::saveSession('auth.password_confirmed_at', time());
    }

    /**
     * Obtiene confirmacion para OTP
     */
    public static function getConfirmedOtp(): int
    {
        return (int) self::getSession(self::KEY_OTP_CONFIRMED);
    }

    /**
     * Valida si confirmación para OTP esta expirada
     */
    public static function isConfirmedOtpExpired(): bool
    {
        if (self::getMethod() == TwoFactorAuthenticatorEnum::AUTHENTICATOR->value) {
            $lifetime = 60 * config('google2fa.lifetime', 0);
        } else {
            $lifetime = 60 * config('telegram.lifetime', 0);
        }
        if ($lifetime) {
            // VENCE
            if (self::getConfirmedOtp()) {
                return now()->parse(self::getConfirmedOtp())->diffInUTCSeconds(now()) > $lifetime;
            } else {
                return true;
            }
        } else {
            // NO VENCE
            return false;
        }
    }

    /**
     * Guarda confirmed_at para ambos casos
     */
    public static function saveConfirmed()
    {
        if (self::getTipo2fa() == 'auth') {
            self::saveConfirmedAuth();
        }
        self::saveConfirmedOtp();
    }

    /**
     * Obtiene confirmación de AUTH en formato
     */
    public static function getFormatConfirmedAuth(): string|null
    {
        if (self::getConfirmedAuth()) {
            return now()->parse(self::getConfirmedAuth())->fechaHumanos();
        }
        return null;
    }

    /**
     * Obtiene confirmacion de Auth en formato con Metodo AUTHENTICATOR APP
     */
    public static function getAuthenticatorConfirmedAuth(): string|null
    {
        if (self::getSession(self::KEY_AUTH_METHOD) == TwoFactorAuthenticatorEnum::AUTHENTICATOR->value) {
            return self::getFormatConfirmedAuth();
        }
        return null;
    }

    /**
     * Obtiene confirmacion de Auth en formato con Metodo TELEGRAM APP
     */
    public static function getTelegramConfirmedAuth(): string|null
    {
        if (self::getSession(self::KEY_AUTH_METHOD) == TwoFactorAuthenticatorEnum::TELEGRAM->value) {
            return self::getFormatConfirmedAuth();
        }
        return null;
    }

    /**
     * Obtiene confirmación de AUTH en formato
     */
    public static function getFormatConfirmedOtp(): string|null
    {
        if (self::getConfirmedOtp()) {
            return now()->parse(self::getConfirmedOtp())->fechaHumanos();
        }
        return null;
    }

    /**
     * Obtiene confirmacion de Auth en formato con Metodo AUTHENTICATOR APP
     */
    public static function getAuthenticatorConfirmedOtp(): string|null
    {
        if (self::getSession(self::KEY_OTP_METHOD) == TwoFactorAuthenticatorEnum::AUTHENTICATOR->value) {
            return self::getFormatConfirmedOtp();
        }
        return null;
    }

    /**
     * Obtiene confirmacion de Auth en formato con Metodo TELEGRAM APP
     */
    public static function getTelegramConfirmedOtp(): string|null
    {
        if (self::getSession(self::KEY_OTP_METHOD) == TwoFactorAuthenticatorEnum::TELEGRAM->value) {
            return self::getFormatConfirmedOtp();
        }
        return null;
    }
}
