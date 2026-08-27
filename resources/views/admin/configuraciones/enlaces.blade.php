@extends('layouts/app')

@section('titulo', 'Gestión de Enlaces')

@section('content')
    <x-section class="space-y-4 p-5 sm:space-y-6 sm:p-8 bg-gray-50/30 dark:bg-neutral-900/30 rounded-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <x-titulo titulo="Gestión de Enlaces Dinámicos" class="text-gradient font-extrabold text-3xl" />
        </div>
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Enlaces Dinámicos
            </x-breadcrumb.current>
        </x-breadcrumb>

        <div class="bg-white dark:bg-neutral-900/50 border border-gray-100 dark:border-neutral-700/50 rounded-2xl p-6 md:p-8 shadow-sm max-w-5xl mx-auto">
            <div class="mb-8 border-b border-gray-100 dark:border-neutral-800 pb-5">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <i class="bx bx-link-alt text-xl"></i>
                    </div>
                    Configuración de Redirecciones
                </h3>
                <p class="text-sm font-medium text-gray-500 mt-3 leading-relaxed max-w-3xl">
                    Aquí puedes configurar las direcciones (URLs) a las que llevarán los botones principales de la página pública.
                    Si dejas un campo vacío, el botón correspondiente no hará nada o recargará la página por defecto.
                </p>
            </div>

            <form action="{{ route('admin.config.enlaces.guardar') }}" method="POST" class="space-y-6">
                @csrf

                @foreach($grupos as $nombreGrupo => $clavesGrupo)
                    <div class="border border-gray-100 dark:border-neutral-700/50 rounded-xl overflow-hidden shadow-sm bg-gray-50/50 dark:bg-neutral-800/30 transition-all hover:shadow-md group">
                        <div class="bg-gray-100/50 dark:bg-neutral-800/80 border-b border-gray-100 dark:border-neutral-700/50 px-5 py-4 flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-gray-200 dark:bg-neutral-700 flex items-center justify-center text-gray-600 dark:text-neutral-400 group-hover:bg-red-100 group-hover:text-red-600 dark:group-hover:bg-red-900/30 dark:group-hover:text-red-400 transition-colors">
                                <i class="bx bx-folder"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-800 dark:text-neutral-200">
                                {{ $nombreGrupo }}
                            </h3>
                        </div>
                        <div class="p-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($clavesGrupo as $clave => $titulo)
                            <div>
                                <label for="{{ $clave }}" class="block text-sm font-bold mb-1.5 dark:text-white text-gray-700">{{ $titulo }}</label>
                                <div class="relative group/input">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                        <i class="bx bx-link text-gray-400 group-focus-within/input:text-red-500 transition-colors"></i>
                                    </div>
                                    <input type="url" name="{{ $clave }}" id="{{ $clave }}" value="{{ $enlaces[$clave] ?? '' }}" 
                                           placeholder="https://ejemplo.com"
                                           class="py-2.5 px-4 ps-11 block w-full border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 dark:placeholder-neutral-500 shadow-sm hover:border-gray-300 dark:hover:border-neutral-600 transition-colors">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-neutral-800">
                    <button type="submit" class="py-2.5 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white shadow-md shadow-red-500/30 hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all inline-flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bx bx-save text-lg"></i> Guardar Enlaces
                    </button>
                </div>
            </form>
        </div>
    </x-section>
@endsection
