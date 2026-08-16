<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar roles.');
        $roles = Role::where('name', '!=', 'super-admin')->orderBy('id')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar roles.');
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create(['name' => $request->name, 'guard_name' => 'web']);

        return back()->with('success', 'Rol creado exitosamente.');
    }

    public function update(Request $request, Role $role)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar roles.');
        if ($role->name === 'admin') {
            return back()->with('error', 'No puedes modificar el rol principal del sistema.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return back()->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Acceso denegado. Solo el administrador puede gestionar roles.');
        if ($role->name === 'admin') {
            return back()->with('error', 'No puedes eliminar el rol principal del sistema.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
        }

        $role->delete();

        return back()->with('success', 'Rol eliminado exitosamente.');
    }
}
