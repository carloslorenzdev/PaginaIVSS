@extends('layouts/app')

@section('titulo', 'Administrar Permisos - ' . Str::title($role->name))

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Administrar Permisos: {{ Str::title($role->name) }}" />
            
            <a href="{{ route('usuarios.control_acceso.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                <i class="bx bx-arrow-back"></i> Volver
            </a>
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('usuarios.control_acceso.index') }}" icono="bx bx-shield">
                Control de Acceso
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                {{ Str::title($role->name) }}
            </x-breadcrumb.current>
        </x-breadcrumb>

        <form action="{{ route('usuarios.control_acceso.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            
            <x-card class="p-6">
                <div class="mb-6 border-b border-gray-200 dark:border-neutral-700 pb-4 flex justify-between items-end">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="bx bx-check-shield text-teal-600"></i> Matriz de Permisos
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Selecciona qué acciones puede realizar este rol en cada módulo.</p>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="button" id="btn-marcar-todos" class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Marcar Todos</button>
                        <span class="text-gray-300 dark:text-neutral-600">|</span>
                        <button type="button" id="btn-desmarcar-todos" class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Desmarcar Todos</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissions as $grupo => $permisos)
                        <div class="bg-gray-50 dark:bg-neutral-900/50 rounded-xl border border-gray-200 dark:border-neutral-700 overflow-hidden">
                            <div class="bg-gray-100 dark:bg-neutral-800 px-4 py-3 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center">
                                <h4 class="font-bold text-gray-800 dark:text-neutral-200 uppercase text-xs tracking-wider">
                                    Módulo: {{ Str::title(str_replace('_', ' ', $grupo)) }}
                                </h4>
                                @php
                                    $grupoIds = collect($permisos)->pluck('id')->toArray();
                                    $todosMarcados = count(array_intersect($grupoIds, $rolePermissions)) === count($grupoIds);
                                @endphp
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="check-grupo sr-only peer" data-grupo="{{ $grupo }}" {{ $todosMarcados ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                </label>
                            </div>
                            <div class="p-4 space-y-3">
                                @foreach($permisos as $permiso)
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="relative flex items-center h-5 mt-0.5">
                                            <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}" 
                                                class="sr-only peer permiso-checkbox checkbox-grupo-{{ $grupo }}"
                                                {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                        </div>
                                        <div class="ml-3 text-sm flex-1">
                                            <span class="font-medium text-gray-700 dark:text-neutral-300 group-hover:text-teal-600 transition-colors">
                                                {{ explode('.', $permiso->name)[1] ?? $permiso->name }}
                                            </span>
                                            <span class="block text-xs text-gray-400 mt-0.5 font-mono">{{ $permiso->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-neutral-700 flex justify-end gap-3">
                    <a href="{{ route('usuarios.control_acceso.index') }}" class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-700 dark:border-neutral-600 dark:text-neutral-300 transition-all">
                        Cancelar
                    </a>
                    <button type="submit" class="py-2 px-4 text-sm font-semibold rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all inline-flex items-center gap-2 shadow-md">
                        <i class="bx bx-save"></i> Guardar Permisos
                    </button>
                </div>
            </x-card>
        </form>
    </x-section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Checkbox global para grupo
            const groupCheckboxes = document.querySelectorAll('.check-grupo');
            
            groupCheckboxes.forEach(function(groupCheckbox) {
                const grupo = groupCheckbox.getAttribute('data-grupo');
                const permisos = document.querySelectorAll('.checkbox-grupo-' + grupo);
                
                // Set initial state of group checkbox based on children
                const allChecked = Array.from(permisos).every(cb => cb.checked);
                const someChecked = Array.from(permisos).some(cb => cb.checked);
                groupCheckbox.checked = allChecked;
                groupCheckbox.indeterminate = someChecked && !allChecked;

                // Click event on group checkbox
                groupCheckbox.addEventListener('change', function() {
                    permisos.forEach(function(permiso) {
                        permiso.checked = groupCheckbox.checked;
                    });
                });

                // Update group checkbox when a child is clicked
                permisos.forEach(function(permiso) {
                    permiso.addEventListener('change', function() {
                        const allChecked = Array.from(permisos).every(cb => cb.checked);
                        const someChecked = Array.from(permisos).some(cb => cb.checked);
                        groupCheckbox.checked = allChecked;
                        groupCheckbox.indeterminate = someChecked && !allChecked;
                    });
                });
            });

            // Marcar todos
            document.getElementById('btn-marcar-todos').addEventListener('click', function() {
                document.querySelectorAll('.permiso-checkbox').forEach(cb => cb.checked = true);
                groupCheckboxes.forEach(cb => { cb.checked = true; cb.indeterminate = false; });
            });

            // Desmarcar todos
            document.getElementById('btn-desmarcar-todos').addEventListener('click', function() {
                document.querySelectorAll('.permiso-checkbox').forEach(cb => cb.checked = false);
                groupCheckboxes.forEach(cb => { cb.checked = false; cb.indeterminate = false; });
            });
        });
    </script>
@endsection
