<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\SesionUsuario;
use App\Models\User;
use App\Services\Auth\AuthenticatorAppService;
use App\Services\Auth\TelegramService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PerfilController extends Controller
{
    /**
     * Información del perfil
     */
    public function detalle(Request $request): View
    {
        /** @var User */
        $user = $request->user();
        $user->load('roles');
        $accesos = SesionUsuario::where('created_by', $user->id)->orderByDesc('created_at')->limit(5)->get();
        $twoFactors = [
            'authenticator' => [
                'nombre' => 'Authenticator App',
                'descripcion' => 'Utiliza la app móvil 2FA de Google, Microsof o Authy',
                'icono' => 'bxs-shield',
                'color' => $user->google2faEnabled() ? 'teal' : 'yellow',
                'estatus' => $user->google2faEnabled() ? 'Habilitado' : 'Deshabilitado',
                'icono_estatus' => $user->google2faEnabled() ? 'bx-check' : 'bx-block',
                'ruta' => route('perfil.2fa.authenticator-app.configuracion')
            ],
            'correo' => [
                'nombre' => 'Correo Electrónico',
                'descripcion' => 'Utiliza el correo electrónico asociado a tu usuario',
                'icono' => 'bxs-envelope',
                'color' => 'gray',
                'estatus' => 'No disponible',
                'icono_estatus' => 'bx-x',
                'ruta' => '#'
            ],
            'telegram' => [
                'nombre' => 'Telegram App',
                'descripcion' => 'Utiliza la app móvil de Telegram',
                'icono' => 'bxl-telegram',
                'color' => $user->telegram2faEnabled() ? 'teal' : 'yellow',
                'estatus' => $user->telegram2faEnabled() ? 'Habilitado' : 'Deshabilitado',
                'icono_estatus' => $user->telegram2faEnabled() ? 'bx-check' : 'bx-block',
                'ruta' => route('perfil.2fa.telegram-app.configuracion')
            ],
        ];
        // authenticator
        if (!AuthenticatorAppService::isEnabled()) {
            $twoFactors['authenticator']['color'] = 'gray';
            $twoFactors['authenticator']['estatus'] = 'No Disponible';
            $twoFactors['authenticator']['icono_estatus'] = 'bx-x';
        }
        // telegram
        if (!TelegramService::isEnabled()) {
            $twoFactors['telegram']['color'] = 'gray';
            $twoFactors['telegram']['estatus'] = 'No Disponible';
            $twoFactors['telegram']['icono_estatus'] = 'bx-x';
        }
        return view('perfil.detalle', compact('user', 'accesos', 'twoFactors'));
    }

    /**
     * PUT para actualizar contraseña
     */
    public function actualizaPass(Request $request): RedirectResponse
    {
        /** @var User */
        $userAuth = $request->user();

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults()->min(8)->max(100), 'confirmed'],
        ]);

        $userAuth->password = Hash::make($validated['password']);
        $userAuth->cambio_pass = now();
        $userAuth->updated_by = $userAuth->id;
        $userAuth->save();

        Log::channel('acciones')->info('Usuario "' . $userAuth->usuario . '" ha actualizado su contraseña.');

        return back()->withAlert(['success', 'Contraseña actualizada']);
    }

    /**
     * Vista con la información sobre 2FA
     */
    public function twoFacorAuth(Request $request): View
    {
        $twoFactors = [
            'authenticator' => [
                'nombre' => 'Authenticator App',
                'descripcion' => 'Utiliza la app móvil 2FA de MIcrosoft, Google o Authy',
                'icono' => 'bxs-shield',
                'estatus' => AuthenticatorAppService::isEnabled(),
                'ruta' => route('perfil.2fa.authenticator-app.configuracion')
            ],
            'correo' => [
                'nombre' => 'Correo Electrónico',
                'descripcion' => 'Utiliza el correo electrónico asociado a tu usuario',
                'icono' => 'bxs-envelope',
                'estatus' => false,
                'ruta' => '#'
            ],
            'telegram' => [
                'nombre' => 'Telegram App',
                'descripcion' => 'Utiliza la app móvil de Telegram para autenticarte',
                'icono' => 'bxl-telegram',
                'estatus' => TelegramService::isEnabled(),
                'ruta' => route('perfil.2fa.telegram-app.configuracion')
            ],
        ];
        return view('perfil.2fa.index', compact('twoFactors'));
    }
}
