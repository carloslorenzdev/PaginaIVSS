<?php

namespace App\Services\Auth;

use App\Models\User as ModelsUser;
use App\Traits\EnableDisable2faTrait;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\User;

class TelegramService
{
    use EnableDisable2faTrait;

    /**
     * Key cache para estatus del bot
     */
    public const BOT_ESTATUS = 'telegram_bot_estatus';

    /**
     * Key cache para información del bot
     */
    public const BOT_INFO = 'telegram_bot_info';

    /**
     * límite de mensajes a obtener
     */
    public const LIMITE_MENSAJES = 50;

    /**
     * Key cache para Ultimo update leido
     */
    public const ULTIMO_MENSAJE = 'telegram_ultimo_mensaje';

    /**
     * Key cache sufijo para datos temporales para activar 2fa
     */
    public const TWO_FACTOR_INFO_TEMP = 'telegram_two_factor_info_temp_';

    /**
     * Key cache sufijo para codigos OTP
     */
    public const TWO_FACTOR_CODE_OTP = 'telegram_two_factor_codigo_';

    /**
     * Key cache prefijo para marcar envio de codigo
     */
    public const ENVIO_CODIGO = 'telegram_envio_codigo_';

    /**
     * Key cache prefijo para marcar intento fallido de validacion codigo OTP
     */
    public const VALIDACION_FALLIDA_CODIGO = 'telegram_validacion_fallida_codigo_';

    /**
     * Key cache prefijo para uso luego de activar metodo al usuario
     */
    public const ACTIVACION_USUARIO = 'telegram_two_factor_activacion_';

    /**
     * Key para nombre columna clave secreta (config)
     */
    public static function secretColumn(): string|null
    {
        return config('telegram.otp_secret_column');
    }

    /**
     * Key para nombre columna confirmación activacion (config)
     */
    public static function secretConfirmedAt(): string|null
    {
        return config('telegram.otp_secret_confirmed');
    }

    /**
     * Verifica si el servicio esta habilitado y activo (.env y api-bot)
     */
    public static function isEnabled(): bool
    {
        return Cache::remember(self::BOT_ESTATUS, 60 * 5, function () {
            $enabled = config('telegram.enabled', false);
            if ($enabled) {
                return self::info() instanceof User;
            }
            return false;
        });
    }

    /**
     * Información del bot
     */
    public static function info()
    {
        return Cache::remember(self::BOT_INFO, 60 * 10, function () {
            try {
                return Telegram::getMe();
            } catch (\Throwable $th) {
                Log::error($th, ['clase' => 'error en info() de ' . self::class]);
                return null;
            }
        });
    }

    /**
     * Genera información de activación para el usuario
     */
    public static function generaInfoActivacion(ModelsUser $user)
    {
        $limite = 60 * config('telegram.lifetime', 5);
        return Cache::remember(self::TWO_FACTOR_INFO_TEMP . $user->id, $limite, function () use ($user, $limite) {
            $data = [];
            $botInfo = self::info();
            $code = Str::upper(Str::random());
            Cache::remember($code, $limite, function () use ($user) {
                return $user->id;
            });
            $renderer = new ImageRenderer(
                new RendererStyle(500),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $data['clave'] = $code;
            $data['isDesktop'] = (new Agent())->isDesktop();
            $data['device'] = "tg://resolve?domain={$botInfo->getUsername()}&start={$code}";
            $data['qr'] = base64_encode($writer->writeString($data['device']));
            $data['link'] = "https://t.me/{$botInfo->getUsername()}?start={$code}";
            return $data;
        });
    }

    /**
     * Genera Throttle Key para validacion fallida OTP
     */
    public static function throttleKeyFailValidateOtp(ModelsUser $user): string
    {
        return self::VALIDACION_FALLIDA_CODIGO . $user->id;
    }

    /**
     * Genera Throttle Key para validacion fallida OTP
     */
    public static function throttleKeySendOtp(ModelsUser $user): string
    {
        return self::ENVIO_CODIGO . $user->id;
    }

    /**
     * Último mensaje leído de api bot
     */
    public static function ultimoMensajeId()
    {
        $id = Cache::get(self::ULTIMO_MENSAJE, 0);
        if (!$id) {
            self::setUltimoMensajeId($id);
        }
        return $id;
    }

    /**
     * Guarda último mensaje leído del api
     */
    public static function setUltimoMensajeId(string|int $id)
    {
        Cache::forget(self::ULTIMO_MENSAJE);
        Cache::rememberForever(self::ULTIMO_MENSAJE, fn() => $id);
    }

    /**
     * Obtiene el código de validación (id usuario)
     */
    public static function getUserIdCodigo(string $codigo)
    {
        return Cache::get($codigo);
    }

    /**
     * Obtiene información del código del usuario
     */
    public static function getInfoCodigoUsuario(string|int $idUsuario)
    {
        return Cache::get(self::TWO_FACTOR_INFO_TEMP . $idUsuario);
    }

    /**
     * Obtiene los mensajes del bot
     */
    public static function getMensajes()
    {
        if (!self::isEnabled()) {
            return null;
        }
        return Telegram::getUpdates([
            'limit' => self::LIMITE_MENSAJES,
            'offset' => self::ultimoMensajeId() + 1,
        ]);
    }

    /**
     * Envía mensaje al chat
     */
    public static function enviaMensaje(string|int $chat, string $mensaje)
    {
        Telegram::sendChatAction([
            'chat_id' => $chat,
            'action' => Actions::TYPING
        ]);
        Telegram::sendMessage([
            'chat_id' => $chat,
            'text' => $mensaje,
            'parse_mode ' => 'MarkdownV2',
        ]);
    }

    /**
     * Envía mensaje codigo no existe
     */
    public static function respuestaCodigoNoExiste(string|int $chat)
    {
        self::enviaMensaje(
            $chat,
            "Código de verificación no existe o está vencido.\n\nPor favor, refresca la página para obtener uno nuevo."
        );
    }

    /**
     * Envía código (6 dígitos)
     */
    public static function enviaCodigoOtp(ModelsUser $user)
    {
        $limite = 60 * config('telegram.lifetime', 5);
        $codigo = mt_rand(111111, 999999);
        Cache::remember(self::TWO_FACTOR_CODE_OTP . $user->id . '_' . $codigo, $limite, function () use ($user) {
            return $user->id;
        });
        self::enviaMensaje(
            $user->{self::secretColumn()},
            "Tu código de verificación es:\n\n" . $codigo . "\n\nNo lo compartas con nadie."
        );
    }

    /**
     * Valida codigo OTP
     */
    public static function validaCodigoOtp(ModelsUser $user, string|int $codigo): bool
    {
        return (bool) Cache::get(self::TWO_FACTOR_CODE_OTP . $user->id . '_' . $codigo) == $user->id;
    }

    /**
     * Set key activación al usuario para evitar doble verificacion
     */
    public static function setKeyActivacion(ModelsUser $user)
    {
        Cache::put(self::ACTIVACION_USUARIO . $user->id, $user->id, 60 * 5);
    }

    /**
     * Obtiene key de activacion del usuario
     */
    public static function getKeyActivacion(ModelsUser $user): int
    {
        return (int) Cache::get(self::ACTIVACION_USUARIO . $user->id);
    }

    /**
     * Elimina key de activacion del usuario
     */
    public static function deleteKeyActivacion(ModelsUser $user)
    {
        Cache::forget(self::ACTIVACION_USUARIO . $user->id);
    }

    /**
     * Procesa mensajes recibidos para activacion de 2fa
     */
    public static function procesaMensajesActivacion2fa()
    {
        collect(self::getMensajes())->map(function ($update) {
            self::setUltimoMensajeId($update->getUpdateId());
            $text = str($update->getMessage()->getText())->squish();
            if (str($text)->startsWith('/start ') && preg_match('/\/start [A-Z0-9]{16}/', $text)) {
                // formato correcto
                $text = explode(' ', $text);
                if (count($text) == 2) {
                    // tiene codigo
                    $codigo = self::getUserIdCodigo($text[1]);
                    if ($codigo) {
                        $data = self::getInfoCodigoUsuario($codigo);
                        $usuario = ModelsUser::whereId($codigo)->first();
                        if ($usuario && $usuario->isActivo() && !$usuario->telegram2faEnabled() && $data && $data['clave'] == $text[1]) {
                            // activa 2fa telegram
                            self::activar($usuario, $update->getChat()->getId());
                            self::setKeyActivacion($usuario);
                            Log::channel('acciones')
                                ->info('El usuario "' . $usuario->usuario . '" ha activado el método 2FA de Telegram App');
                            self::enviaMensaje(
                                $update->getChat()->getId(),
                                "Activación de exitosa. \n\nRecuerda no eliminar este chat"
                            );
                            Cache::forget($text[1]);
                            Cache::forget(self::TWO_FACTOR_INFO_TEMP . $usuario->id);
                        } else {
                            self::respuestaCodigoNoExiste($update->getChat()->getId());
                        }
                    } else {
                        self::respuestaCodigoNoExiste($update->getChat()->getId());
                    }
                } else {
                    // responder con mensaje erroneo e indicar el formato correcto
                    // o tomar chat para tomar en cuenta los intentos erroneos y en caso de superar
                    // limite bloquear chat por 48hrs
                }
            }
        });
    }
}
