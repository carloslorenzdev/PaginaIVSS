@extends('layouts/app')

@section('titulo', 'Control de Acceso')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Control de Acceso" class="text-gradient font-extrabold text-3xl" />
        </div>

        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Control de Acceso
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-5 dark:bg-blue-900/20 dark:border-blue-800/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="bx bx-shield-quarter text-6xl text-blue-600"></i>
            </div>
            <div class="flex items-start gap-4 relative z-10">
                <div class="flex-shrink-0 size-10 rounded-full bg-blue-100 dark:bg-blue-800/50 flex items-center justify-center">
                    <i class="bx bx-info-circle text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="flex-1 mt-2">
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        Selecciona un rol de la lista para administrar qué módulos puede ver y qué acciones puede realizar dentro del panel.
                    </p>
                </div>
            </div>
        </div>


        <div class="space-y-4">
            @forelse($roles as $rol)
                <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-xl p-5 hover:shadow-md transition-all duration-300 group">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                        
                        {{-- NOMBRE --}}
                        <div class="flex-1 min-w-0 flex items-center gap-4">
                            <div class="size-14 rounded-2xl bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center flex-shrink-0 text-teal-600 dark:text-teal-400 border border-teal-100 dark:border-teal-900/50">
                                <i class="bx bx-shield text-3xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white text-xl truncate">
                                    {{ Str::title($rol->name) }}
                                </p>
                                <p class="text-sm mt-1 font-medium text-gray-500 dark:text-neutral-400 truncate">
                                    Administrar privilegios
                                </p>
                            </div>
                        </div>

                        {{-- ESTADÍSTICAS Y ACCIONES --}}
                        <div class="flex items-center gap-6 lg:gap-8 mt-4 lg:mt-0">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-neutral-500 mb-1.5">Permisos Actuales</p>
                                <p class="text-sm font-bold text-purple-600 dark:text-purple-400 flex items-center bg-purple-50 dark:bg-purple-900/20 px-3 py-1 rounded-lg border border-purple-100 dark:border-purple-900/50 w-fit">
                                    <i class="bx bx-check-shield mr-1.5"></i> {{ $rol->permissions()->count() }}
                                </p>
                            </div>
                            
                            <div class="border-l border-gray-100 dark:border-neutral-700 pl-6 lg:pl-8">
                                @if(auth()->user()->hasRole($rol->name))
                                    <span class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-neutral-800 px-5 py-2.5 text-sm font-bold text-gray-400 dark:text-neutral-500 cursor-not-allowed" title="No puedes editar tus propios privilegios por motivos de seguridad">
                                        <i class="bx bx-user-check text-lg"></i> Tu Rol Actual
                                    </span>
                                @else
                                    <a href="{{ route('usuarios.control_acceso.edit', $rol) }}" 
                                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-600 to-teal-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-teal-500/30 hover:shadow-lg hover:from-teal-700 hover:to-teal-600 transition-all transform hover:-translate-y-0.5">
                                        <i class="bx bx-slider-alt text-lg"></i> Administrar Permisos
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-16 text-center border-2 border-dashed border-gray-200 dark:border-neutral-700/50 bg-gray-50/50 dark:bg-neutral-800/20 rounded-2xl">
                    <div class="size-20 mx-auto bg-white dark:bg-neutral-800 rounded-full flex items-center justify-center mb-5 shadow-sm border border-gray-100 dark:border-neutral-700">
                        <i class="bx bx-shield-x text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay roles disponibles</h3>
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Cree roles primero en el módulo de Roles.</p>
                </div>
            @endforelse
        </div>
    </x-section>
@endsection

