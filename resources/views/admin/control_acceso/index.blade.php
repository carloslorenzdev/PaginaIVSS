@extends('layouts/app')

@section('titulo', 'Control de Acceso')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <div class="flex items-center justify-between">
            <x-titulo titulo="Control de Acceso" />
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Control de Acceso
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 dark:bg-blue-900/30">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bx bx-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-400">
                        Selecciona un rol de la lista para administrar qué módulos puede ver y qué acciones puede realizar dentro del panel.
                    </p>
                </div>
            </div>
        </div>


        <x-card class="p-5">
            <div class="space-y-4">
                @forelse($roles as $rol)
                    <x-card class="p-4 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            {{-- NOMBRE --}}
                            <div class="flex-1 min-w-0 flex items-center gap-3">
                                <div class="size-12 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0 text-teal-600 dark:text-teal-400">
                                    <i class="bx bx-shield text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-base truncate">
                                        {{ Str::title($rol->name) }}
                                    </p>
                                    <p class="text-xs mt-1 text-gray-500 dark:text-neutral-400 truncate">
                                        Administrar privilegios
                                    </p>
                                </div>
                            </div>

                            {{-- ESTADÍSTICAS Y ACCIONES --}}
                            <div class="flex items-center gap-6">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-500 mb-1">Permisos Actuales</p>
                                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400 flex items-center">
                                        <i class="bx bx-check-shield mr-1"></i> {{ $rol->permissions()->count() }}
                                    </p>
                                </div>
                                
                                <div class="border-l border-gray-200 dark:border-neutral-700 pl-6">
                                    <a href="{{ route('usuarios.control_acceso.edit', $rol) }}" 
                                        class="inline-flex items-center gap-2 rounded-lg bg-white border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 shadow-sm">
                                        <i class="bx bx-slider-alt"></i> Administrar Permisos
                                    </a>
                                </div>
                            </div>

                        </div>
                    </x-card>
                @empty
                    <div class="text-center py-10">
                        <i class="bx bx-shield-x text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">No hay roles disponibles para configurar.</p>
                        <p class="text-sm text-gray-400">Cree roles primero en el módulo de Roles.</p>
                    </div>
                @endforelse
            </div>
        </x-card>
    </x-section>
@endsection
