<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionFingerprintMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // No vincular la sesión estrictamente a la IP volátil del cliente para evitar deslogueos por rotación de proxies (CWE-348)
            $currentFingerprint = hash('sha256', (string) $request->userAgent());

            if (!Session::has('session_fingerprint')) {
                Session::put('session_fingerprint', $currentFingerprint);
            } else {
                if (Session::get('session_fingerprint') !== $currentFingerprint) {
                    Auth::logout();
                    Session::invalidate();
                    Session::regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'usuario' => 'Tu sesión ha sido cerrada por seguridad al detectarse un cambio en tu conexión o navegador.'
                    ]);
                }
            }
        }

        return $next($request);
    }
}
