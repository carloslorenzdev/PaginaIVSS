<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ListarUsuariosController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_if(!auth()->user()->can('usuarios.ver'), 403, 'Acceso denegado: No tienes permiso para ver usuarios.');

        $query = User::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('usuario', 'like', "%{$search}%");
            });
        }

        $usuarios = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.usuarios.index', compact('usuarios'));
    }
}
