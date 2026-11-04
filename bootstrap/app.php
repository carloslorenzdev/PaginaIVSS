<?php

use App\Http\Middleware\AddContextLog;
use App\Http\Middleware\CheckChangePassword;
use App\Http\Middleware\CheckUltimaActualizacionEmpresa;
use App\Http\Middleware\CheckUserHasTwoFactorActive;
use App\Http\Middleware\CheckUserIsActive;
use App\Http\Middleware\EnsureSolicitudIsPending;
use App\Http\Middleware\EnsureTwoFactorIsEnabled;
use App\Http\Middleware\EnsureUserHasAnyTwoFactorEnabled;
use App\Http\Middleware\EnsureAuthUserIsActive;
use App\Http\Middleware\TwoFactorAuthenticator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustHosts;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Spatie\Csp\AddCspHeaders;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $trustedProxies = env('TRUSTED_PROXIES');
        if ($trustedProxies) {
            $middleware->trustProxies(at: array_map('trim', explode(',', $trustedProxies)));
        } else {
            // Limitar confianza de proxies a redes privadas internas y reverse proxies conocidos (CWE-348 / CWE-290)
            $middleware->trustProxies(at: [
                '127.0.0.1',
                '::1',
                '10.0.0.0/8',
                '192.168.0.0/16',
                '172.16.0.0/12',
            ]);
        }

        // Restringir hosts permitidos a dominios institucionales
        $middleware->trustHosts(at: [
            'ivss.gob.ve',
            '*.ivss.gob.ve',
            'localhost',
            '127.0.0.1',
        ]);

        $middleware->throttleWithRedis();
        $middleware->redirectUsersTo('/admin/panel');
        $middleware->append([
            AddCspHeaders::class,
            AddContextLog::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\SessionFingerprintMiddleware::class,
        ]);
        $middleware->alias([
            '2fa' => TwoFactorAuthenticator::class,
            '2fa.disponible' => EnsureTwoFactorIsEnabled::class,
            '2fa.habilitado' => EnsureUserHasAnyTwoFactorEnabled::class,
            '2fa.activo' => CheckUserHasTwoFactorActive::class,
            // USUARIO AUTENTICADO
            'auth.activo' => EnsureAuthUserIsActive::class,
            'auth.cambio_pass' => CheckChangePassword::class,
            // USUARIO PARAMETRO RECUEST
            'usuario.activo' => CheckUserIsActive::class,
            // SOLICITUDES NUEVO PATRONO
            'solicitud.pendiente' => EnsureSolicitudIsPending::class,
            // EMPRESA
            'empresa.actualizacion' => CheckUltimaActualizacionEmpresa::class,
            // ROLES
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InvalidSignatureException $e) {
            return response()->view('errors.link-expired', status: 404);
        });
    })->create();
