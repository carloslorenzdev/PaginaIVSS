<?php

namespace App\Http\Controllers\Usuario;

use App\Enums\TwoFactorAuthenticatorEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\Desactivar2faRequest;
use App\Models\User;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TelegramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class Usuario2faController extends Controller
{
    /**
     * Formulario para desactivar algun/todos los métodos de 2fa
     */
    public function desactivar(User $usuario): View|RedirectResponse
    {
        $this->authorize('update', $usuario);

        if (!$usuario->hasEnabled2fa()) {
            return to_route('usuarios.detalle', $usuario)->withAlert([
                'danger',
                [
                    'mensaje' => '2FA deshabilitado',
                    'ayuda' => 'Usuario no posee algún método de autenticación de dos factores activo',
                ]
            ]);
        }
        $twoFactors = [
            'authenticator' => [
                'estatus' => $usuario->google2faEnabled(),
                'icono' => 'bxs-shield'
            ],
            'correo' => [
                'estatus' => $usuario->emailEnabled(),
                'icono' => 'bxs-envelope'
            ],
            'telegram' => [
                'estatus' => $usuario->telegram2faEnabled(),
                'icono' => 'bxl-telegram'
            ],
        ];
        return view('usuarios.desactivar-2fa', compact('usuario', 'twoFactors'));
    }

    /**
     * POST para desactivar metodos de 2fa
     */
    public function desactivar2fa(Desactivar2faRequest $request, User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        if (!$usuario->hasEnabled2fa()) {
            return to_route('usuarios.detalle', $usuario)->withAlert([
                'danger',
                [
                    'mensaje' => '2FA deshabilitado',
                    'ayuda' => 'Usuario no posee algún método de autenticación de dos factores activo',
                ]
            ]);
        }
        DB::transaction(function () use ($request, $usuario) {
            $data = $request->validated();
            $metodos = collect($data['metodo']);
            if ($metodos->contains(TwoFactorAuthenticatorEnum::AUTHENTICATOR->value)) {
                AuthenticatorAppService::desactivar($usuario, $request->user()->id);
                Log::channel('acciones')
                    ->warning('El usuario "' . $request->user()->usuario . '" desactivó el método 2fa Authenticator App al usuaro "' . $usuario->usuario . '"');
            }
            if ($metodos->contains(TwoFactorAuthenticatorEnum::TELEGRAM->value)) {
                TelegramService::desactivar($usuario, $request->user()->id);
                Log::channel('acciones')
                    ->warning('El usuario "' . $request->user()->usuario . '" desactivó el método 2fa Telegram App al usuaro "' . $usuario->usuario . '"');
            }
            // OBSERVACION
            if ($data['observacion']) {
                $usuario->observaciones()->create([
                    'observacion' => '<p>[DESACTIVACION 2FA]</p>' . $data['observacion'],
                    'created_by' => $request->user()->id,
                ]);
            }
        });
        return to_route('usuarios.detalle', $usuario)->withAlert(['success', 'Desactivación exitosa']);
    }
}
