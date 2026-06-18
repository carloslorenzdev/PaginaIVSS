@extends('layouts/app')

@section('titulo', 'Gestión de Enlaces')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Gestión de Enlaces Dinámicos" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('admin.panel') }}" icono="bx bx-tachometer">
                Panel
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Enlaces Dinámicos
            </x-breadcrumb.current>
        </x-breadcrumb>

        <x-card class="p-5 max-w-5xl">
            <div class="mb-6">
                <x-card.title class="mb-2">
                    <i class="bx bx-link-alt"></i> Configuración de Redirecciones
                </x-card.title>
                <p class="text-sm text-gray-500 dark:text-neutral-400">
                    Aquí puedes configurar las direcciones (URLs) a las que llevarán los botones principales de la página pública.
                    Si dejas un campo vacío, el botón correspondiente no hará nada o recargará la página por defecto.
                </p>
            </div>

            <form action="{{ route('admin.config.enlaces.guardar') }}" method="POST" class="space-y-6">
                @csrf

                @foreach($grupos as $nombreGrupo => $clavesGrupo)
                    <div class="border border-gray-200 dark:border-neutral-700 rounded-lg overflow-hidden shadow-sm bg-white dark:bg-neutral-800">
                        <div class="bg-gray-50 dark:bg-neutral-800/80 border-b border-gray-200 dark:border-neutral-700 px-5 py-3">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                                <i class="bx bx-folder"></i> {{ $nombreGrupo }}
                            </h3>
                        </div>
                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($clavesGrupo as $clave => $titulo)
                            <div>
                                <x-input.label for="{{ $clave }}" value="{{ $titulo }}" class="mb-1.5" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3">
                                        <i class="bx bx-link text-gray-400"></i>
                                    </div>
                                    <input type="url" name="{{ $clave }}" id="{{ $clave }}" value="{{ $enlaces[$clave] ?? '' }}" 
                                           placeholder="https://ejemplo.com"
                                           class="py-2.5 px-4 ps-9 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-neutral-700">
                    <x-input.button class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                        <i class="bx bx-save mr-1"></i> Guardar Enlaces
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection
