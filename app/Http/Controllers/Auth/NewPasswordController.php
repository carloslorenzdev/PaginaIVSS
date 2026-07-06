<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Cambio de contraseña al iniciar por primera vez
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function cambioPass(Request $request): View|RedirectResponse
    {
        if (!is_null($request->user()->cambio_pass)) {
            return to_route('admin.panel');
        }
        return view('auth.change-pass');
    }

    /**
     * POST para cambio de contraseña al ingresar por primera vez
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePass(Request $request): RedirectResponse
    {
        if (!is_null($request->user()->cambio_pass)) {
            return to_route('admin.panel');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(8)],
        ]);

        /** @var User */
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->updated_by = $user->id;
        $user->cambio_pass = now();
        $user->save();

        Log::channel('acciones')->info('Usuario "' . $user->usuario . '" ha actualizado su contraseña.');

        return to_route('admin.panel')->withAlert(['success', 'Contraseña cambiada']);
    }

    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
