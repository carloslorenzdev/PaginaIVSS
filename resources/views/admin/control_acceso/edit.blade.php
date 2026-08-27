@extends('layouts/app')

@section('titulo', 'Administrar Permisos - ' . Str::title($role->name))

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Administrar Permisos: {{ Str::title($role->name) }}" class="text-gradient font-extrabold text-3xl" />
            
            <a href="{{ route('usuarios.control_acceso.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 shadow-sm hover:shadow-md">
                <i class="bx bx-arrow-back text-lg"></i> Volver
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
            
            <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 md:p-8 shadow-sm relative overflow-hidden">
                {{-- DECORACIÓN DE FONDO --}}
                <div class="absolute top-0 right-0 p-8 opacity-[0.03] pointer-events-none">
                    <i class="bx bx-fingerprint text-[15rem] text-teal-600"></i>
                </div>

                <div class="mb-8 border-b border-gray-100 dark:border-neutral-800 pb-5 flex flex-col sm:flex-row justify-between sm:items-end gap-4 relative z-10">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="size-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 shadow-sm border border-teal-200 dark:border-teal-800/50">
                                <i class="bx bx-check-shield text-xl"></i>
                            </div>
                            Matriz de Permisos
                        </h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-neutral-400 mt-3 flex items-start gap-2 max-w-2xl">
                            <i class="bx bx-info-circle text-teal-500 mt-0.5 text-lg"></i>
                            Selecciona qué acciones puede realizar este rol en cada módulo. Activa el interruptor principal de un módulo para marcar todos sus permisos rápidamente.
                        </p>
                    </div>
                    
                    <div class="flex gap-3 bg-gray-50 dark:bg-neutral-800 p-2 rounded-xl border border-gray-100 dark:border-neutral-700 shadow-inner">
                        <button type="button" id="btn-marcar-todos" class="px-4 py-2 rounded-lg text-xs font-bold bg-white dark:bg-neutral-700 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-900 shadow-sm hover:shadow hover:-translate-y-0.5 transition-all flex items-center gap-1.5">
                            <i class="bx bx-check-double text-base"></i> Seleccionar Todos
                        </button>
                        <button type="button" id="btn-desmarcar-todos" class="px-4 py-2 rounded-lg text-xs font-bold bg-white dark:bg-neutral-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow hover:-translate-y-0.5 transition-all flex items-center gap-1.5">
                            <i class="bx bx-reset text-base"></i> Limpiar Todos
                        </button>
                    </div>
                </div>

                @php
                    $iconosModulos = [
                        'noticias' => 'bx-news',
                        'usuarios' => 'bx-group',
                        'roles' => 'bx-shield-quarter',
                        'control_acceso' => 'bx-key',
                        'configuracion' => 'bx-cog',
                        'categorias' => 'bx-purchase-tag',
                        'actividades' => 'bx-calendar-event',
                        'directorios' => 'bx-book-content',
                        'boletines' => 'bx-envelope',
                        'revistas' => 'bx-book-open',
                        'banners' => 'bx-image-alt',
                        'carrusel' => 'bx-images',
                        'rendimiento' => 'bx-rocket',
                        'backups' => 'bx-data',
                        'logs' => 'bx-list-ul',
                        'chatbot' => 'bx-bot',
                    ];

                    $detallesAcciones = [
                        'crear' => ['icono' => 'bx-plus-circle', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'desc' => 'Añadir nuevos registros'],
                        'editar' => ['icono' => 'bx-edit', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'desc' => 'Modificar registros existentes'],
                        'eliminar' => ['icono' => 'bx-trash', 'color' => 'text-red-500', 'bg' => 'bg-red-50 dark:bg-red-900/20', 'desc' => 'Borrar permanentemente'],
                        'ver' => ['icono' => 'bx-show', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'desc' => 'Consultar información'],
                        'publicar' => ['icono' => 'bx-upload', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'desc' => 'Hacer público el contenido'],
                        'aprobar' => ['icono' => 'bx-check-double', 'color' => 'text-teal-500', 'bg' => 'bg-teal-50 dark:bg-teal-900/20', 'desc' => 'Validar flujo o acción'],
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                    @foreach($permissions as $grupo => $permisos)
                        @php
                            $iconoModulo = $iconosModulos[$grupo] ?? 'bx-folder';
                            $grupoIds = collect($permisos)->pluck('id')->toArray();
                            $todosMarcados = count(array_intersect($grupoIds, $rolePermissions)) === count($grupoIds);
                        @endphp
                        <div class="bg-white dark:bg-neutral-800/50 rounded-2xl border border-gray-200 dark:border-neutral-700 overflow-hidden shadow-sm hover:shadow-md transition-shadow group/card">
                            {{-- CABECERA DEL MÓDULO --}}
                            <div class="bg-gray-50/80 dark:bg-neutral-800 px-5 py-4 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center transition-colors group-hover/card:bg-teal-50/50 dark:group-hover/card:bg-teal-900/10">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-lg bg-white dark:bg-neutral-700 shadow-sm flex items-center justify-center text-gray-500 dark:text-neutral-400 group-hover/card:text-teal-600 dark:group-hover/card:text-teal-400 transition-colors">
                                        <i class="bx {{ $iconoModulo }} text-lg"></i>
                                    </div>
                                    <h4 class="font-extrabold text-gray-800 dark:text-neutral-200 uppercase text-[11px] tracking-widest">
                                        {{ Str::title(str_replace('_', ' ', $grupo)) }}
                                    </h4>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer" title="Marcar todos los permisos de este módulo">
                                    <input type="checkbox" class="check-grupo sr-only peer" data-grupo="{{ $grupo }}" {{ $todosMarcados ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-teal-500"></div>
                                </label>
                            </div>
                            
                            {{-- LISTADO DE PERMISOS --}}
                            <div class="p-5 space-y-3.5">
                                @foreach($permisos as $permiso)
                                    @php
                                        $accionRaw = explode('.', $permiso->name)[1] ?? $permiso->name;
                                        $detalle = $detallesAcciones[$accionRaw] ?? ['icono' => 'bx-check', 'color' => 'text-gray-500', 'bg' => 'bg-gray-50 dark:bg-neutral-800', 'desc' => 'Permiso específico'];
                                    @endphp
                                    <label class="flex items-start cursor-pointer group/item p-2 -m-2 rounded-xl hover:bg-gray-50 dark:hover:bg-neutral-800/80 transition-colors">
                                        <div class="relative flex items-center h-5 mt-1 mr-3 shrink-0">
                                            <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}" 
                                                class="sr-only peer permiso-checkbox checkbox-grupo-{{ $grupo }}"
                                                {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}>
                                            <div class="w-5 h-5 border-2 border-gray-300 dark:border-neutral-600 rounded md:bg-white dark:bg-neutral-900 peer-checked:bg-teal-500 peer-checked:border-teal-500 transition-colors flex items-center justify-center">
                                                <i class="bx bx-check text-white opacity-0 peer-checked:opacity-100 text-sm transition-opacity"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0 flex items-start gap-3">
                                            <div class="size-8 rounded-lg {{ $detalle['bg'] }} flex items-center justify-center shrink-0 {{ $detalle['color'] }} mt-0.5">
                                                <i class="bx {{ $detalle['icono'] }} text-base"></i>
                                            </div>
                                            <div>
                                                <span class="font-bold text-gray-800 dark:text-neutral-200 capitalize text-sm group-hover/item:text-teal-600 dark:group-hover/item:text-teal-400 transition-colors">
                                                    {{ $accionRaw }}
                                                </span>
                                                <span class="block text-[11px] text-gray-500 dark:text-neutral-400 mt-0.5 leading-tight">
                                                    {{ $detalle['desc'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100 dark:border-neutral-800 flex justify-end gap-3">
                    <a href="{{ route('usuarios.control_acceso.index') }}" class="py-2.5 px-5 text-sm font-bold rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 transition-all shadow-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all inline-flex items-center gap-2">
                        <i class="bx bx-save text-lg"></i> Guardar Permisos
                    </button>
                </div>
            </div>
        </form>
    </x-section>

    @vite('resources/js/admin-control-acceso.js')
@endsection
