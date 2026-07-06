<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ControlAccesoController extends Controller
{
    public function index()
    {
        // El rol 'admin' tiene todos los permisos, no lo mostramos para evitar que lo rompan
        $roles = Role::where('name', '!=', 'admin')->orderBy('id')->get();
        return view('admin.control_acceso.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('usuarios.control_acceso.index')->with('error', 'El rol de Administrador no puede ser modificado.');
        }

        // Obtener todos los permisos y agruparlos por el prefijo (ej. 'noticias.crear' -> 'noticias')
        $permissions = Permission::all()->groupBy(function($perm) {
            return explode('.', $perm->name)[0];
        });

        // Obtener IDs de permisos asignados
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.control_acceso.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('usuarios.control_acceso.index')->with('error', 'El rol de Administrador no puede ser modificado.');
        }

        // Validar array de permisos
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        // Sincronizar permisos (elimina los no pasados y asigna los pasados)
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('usuarios.control_acceso.index')->with('success', 'Permisos actualizados correctamente para el rol: ' . \Str::title($role->name));
    }
}
