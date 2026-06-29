<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Observacion;
use App\Models\SesionUsuario;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Listado de usuarios
     */
    public function listado(Request $request): View
    {
        /** @var User */
        $userAuth = $request->user();

        $usuarios = User::with([
            'creador',
            'modificador',
            'ultimoAcceso',
        ])->withWhereHas('roles', function ($q) use ($userAuth) {
            if (!$userAuth->isAdmin()) {
                $q->whereNotIn('name', ['Admin']);
            }
        });

        $request->whenHas('q', function ($value) use ($usuarios) {
            $usuarios->whereAny([
                'usuario',
                'nombre',
            ], 'LIKE', '%' . Str::upper(Str::squish($value)) . '%');
        });

        $usuarios = $usuarios->orderByDesc('created_at')->paginate()->withQueryString();

        $activos = User::whereNull('bloqueado')->count();
        $sesionesActivas = UserSession::whereNotNull('user_id')->count();

        $rolesQuery = \Spatie\Permission\Models\Role::where('name', '<>', 'Patrono')->orderBy('name');
        if (!$userAuth->isAdmin()) {
            $rolesQuery->where('name', '<>', 'Admin');
        }
        $roles = $rolesQuery->get();

        return view('usuarios.listado', compact('userAuth', 'usuarios', 'activos', 'sesionesActivas', 'roles'));
    }

    /**
     * Detalle de usuario
     */
    public function detalle(Request $request, User $user)
    {
        /** @var User */
        $userAuth = $request->user();

        abort_if(!$userAuth->isAdmin() && $user->isAdmin(), 404);

        $this->authorize('view', $user);

        $user->loadMissing(['roles', 'creador', 'modificador']);

        $accesos = SesionUsuario::where('created_by', $user->id)->orderByDesc('created_at')->limit(5)->get();
        $observaciones = Observacion::with(['creador'])->whereMorphedTo('observaciontable', $user)
            ->orderByDesc('created_at')->limit(3)->get();
        return view('usuarios.detalle', compact('user', 'accesos', 'observaciones'));
    }

    /**
     * Observaciones
     */
    public function observaciones(User $user): View
    {
        $this->authorize('view', $user);

        $observaciones = Observacion::with(['creador'])->whereMorphedTo('observaciontable', $user)
            ->orderByDesc('created_at')->paginate();
        return view('usuarios.observaciones', compact('user', 'observaciones'));
    }
}
