@extends('layouts/app')

@section('titulo', 'Registrar Usuario')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Registrar Usuario" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('usuarios.listado') }}" icono="bx bx-arrow-back">
                Usuarios
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Registrar
            </x-breadcrumb.current>
        </x-breadcrumb>
        <div class="flex justify-center">
            <div class="max-w-sm">
                <div class="space-y-5">
                    <div class="bg-blue-50 border-t-2 border-blue-500 rounded-lg shadow p-4 dark:bg-blue-800/30"
                        role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                        <div class="flex">
                            <div class="shrink-0">
                                <span
                                    class="inline-flex justify-center items-center size-8 rounded-full border-4 border-blue-100 bg-blue-200 text-blue-800 dark:border-blue-900 dark:bg-blue-800 dark:text-blue-400">
                                    <i class='bx bx-message-alt-error shink-0'></i>
                                </span>
                            </div>
                            <div class="ms-3">
                                <h3 id="hs-bordered-success-style-label"
                                    class="text-gray-800 font-semibold dark:text-white">
                                    Información.
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-neutral-400">
                                    Al registrar el usuario, se le enviará un correo con su contraseña temporal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-card class="p-5">
            <x-card.title>
                <i class="bx bx-user-plus"></i>
                Nuevo usuario
            </x-card.title>
            @include('usuarios/registrar/formulario')
        </x-card>
    </x-section>
@endsection
