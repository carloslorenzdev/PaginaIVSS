<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Traits\EnableDisable2faTrait;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FALaravel\Facade as Google2FA;

class AuthenticatorAppService
{
    use EnableDisable2faTrait;

    /**
     * Key cache sufijo para datos temporales para activar 2fa
     */
    public const TWO_FACTOR_INFO_TEMP = '_authenticator_two_factor_info_temp';

    /**
     * Key cache prefijo para marcar intento fallido de validacion codigo OTP
     */
    public const VALIDACION_FALLIDA_CODIGO = '_authenticator_validacion_fallida_codigo_';

    /**
     * Key para nombre columna clave secreta (config)
     */
    public static function secretColumn(): string|null
    {
        return config('google2fa.otp_secret_column');
    }

    /**
     * Key para nombre columna confirmación activacion (config)
     */
    public static function secretConfirmedAt(): string|null
    {
        return config('google2fa.otp_secret_confirmed_at');
    }

    /**
     * Verifica si el servicio esta habilitado y activo (.env)
     */
    public static function isEnabled(): bool
    {
        return (bool) config('google2fa.enabled', false);
    }

    /**
     * Genera información de activación para el usuario
     */
    public static function generaInfoActivacion(User $user)
    {
        return Cache::remember($user->id . self::TWO_FACTOR_INFO_TEMP, 60 * 5, function () use ($user) {
            $data = [];
            $data['clave'] = Google2FA::generateSecretKey();
            $qrCodeUrl = Google2FA::getQRCodeUrl(
                config('app.name'),
                $user->usuario,
                $data['clave']
            );
            // Generar el QR Code SVG
            $renderer = new ImageRenderer(
                new RendererStyle(500),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);

            $data['qr'] = base64_encode($writer->writeString($qrCodeUrl));

            return $data;
        });
    }

    /**
     * Obtiene información temporal de activación del usuario
     */
    public static function getInfoCodigoUsuario(string|int $idUsuario)
    {
        return Cache::get($idUsuario . self::TWO_FACTOR_INFO_TEMP);
    }

    /**
     * Genera Throttle Key para validacion fallida OTP
     */
    public static function throttleKeyFailValidateOtp(User $user): string
    {
        return self::VALIDACION_FALLIDA_CODIGO . $user->id;
    }

    /**
     * Valida codigo OTP
     */
    public static function validaCodigoOtp(string $clave, string|int $codigo)
    {
        return Google2FA::verifyKey($clave, $codigo);
    }

    /**
     * Valida codigo OTP del usuario
     */
    public static function validaCodigoOtpUsuario(User $user, string|int $codigo)
    {
        return self::validaCodigoOtp($user->{self::secretColumn()}, $codigo);
    }
}
