<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SesionUsuario;
use App\Models\UserSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        DB::transaction(function () use ($request) {
            $request->session()->regenerate();

            // CERRAR DEMÁS SESIONES ACTIVAS
            UserSession::where('user_id', $request->user()->id)
                ->whereNot('id', [$request->session()->getId()])->delete();

            // REGISTRAR SESION
            SesionUsuario::create([
                'ip' => $request->ip(),
                'ips' => $request->ips(),
                'ip_client' => $request->getClientIp(),
                'ips_client' => $request->getClientIps(),
                'user_agent' => $request->userAgent(),
                'login' => now(),
                'id_sesion' => $request->session()->getId(),
                'created_by' => $request->user()->id,
            ]);

            Log::channel('acciones')->info('El usuario "' . $request->user()->usuario . '" ha iniciado sesión');
        });

        return redirect()->intended(route('admin.panel', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        $sesion = SesionUsuario::where('created_by', $user->id)
            ->where('id_sesion', $request->session()->getId())
            ->whereNull('logout')->first();
        if ($sesion) {
            $sesion->logout = now();
            $sesion->updated_by = $user->id;
            $sesion->save();
        }

        Auth::guard('web')->logout();

        Log::channel('acciones')->info('El usuario "' . $user->usuario . '" ha cerrado sesión');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
