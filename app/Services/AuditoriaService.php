<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\Models\Activity;

class AuditoriaService
{
    /**
     * Registra un evento de auditoría detallado con rastreo de sesión y ubicación
     */
    public static function registrar(
        string $evento,
        string $descripcion,
        ?Model $subject = null,
        array $propiedades = [],
        ?User $causer = null
    ): ?Activity {
        try {
            $user = $causer ?? auth()->user();
            $agent = new Agent();

            $dispositivo = 'Desktop';
            if ($agent->isTablet()) {
                $dispositivo = 'Tablet';
            } elseif ($agent->isMobile()) {
                $dispositivo = 'Móvil';
            }

            $navegador = $agent->browser() ?: 'Desconocido';
            $sistemaOperativo = $agent->platform() ?: 'Desconocido';
            $ip = request()->ip() ?: '127.0.0.1';
            $url = request()->fullUrl();
            $metodo = request()->method();

            $metadata = array_merge([
                'ip' => $ip,
                'dispositivo' => $dispositivo,
                'navegador' => $navegador,
                'sistema_operativo' => $sistemaOperativo,
                'user_agent' => request()->userAgent() ?? 'N/A',
                'url' => $url,
                'metodo' => $metodo,
            ], $propiedades);

            $activity = Activity::create([
                'log_name' => 'auditoria',
                'description' => $descripcion,
                'subject_type' => $subject ? get_class($subject) : null,
                'subject_id' => $subject ? $subject->getKey() : null,
                'event' => $evento,
                'causer_type' => $user ? get_class($user) : null,
                'causer_id' => $user ? $user->getKey() : null,
                'properties' => $metadata,
            ]);

            // Respaldo en canal de log rotativo de acciones
            $usuarioStr = $user ? ($user->usuario ?? $user->nombre ?? 'ID: ' . $user->id) : 'Sistema';
            Log::channel('acciones')->info("[AUDITORIA] [{$evento}] {$usuarioStr} - {$descripcion} | IP: {$ip} | {$dispositivo} ({$navegador} / {$sistemaOperativo})");

            return $activity;
        } catch (\Throwable $e) {
            Log::error('Error registrando auditoría: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Auditoría de Inicio de Sesión
     */
    public static function login(User $user): void
    {
        self::registrar('login', "El usuario '{$user->usuario}' inició sesión exitosamente", $user, [], $user);
    }

    /**
     * Auditoría de Cierre de Sesión
     */
    public static function logout(User $user): void
    {
        self::registrar('logout', "El usuario '{$user->usuario}' cerró su sesión", $user, [], $user);
    }

    /**
     * Auditoría de Intento de Acceso Fallido
     */
    public static function loginFallido(string $identificador): void
    {
        self::registrar('login_fallido', "Intento fallido de inicio de sesión con el identificador: '{$identificador}'", null, [
            'identificador' => $identificador
        ]);
    }
}

