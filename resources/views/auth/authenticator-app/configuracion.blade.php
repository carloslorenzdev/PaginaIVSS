@extends('layouts/app')

@section('titulo', 'Authenticator App')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Authenticator App" />
        <x-breadcrumb>
            <x-breadcrumb.item icono="bx bx-arrow-back" ruta="{{ route('perfil.detalle') }}">
                Mi Perfil
            </x-breadcrumb.item>
            <x-breadcrumb.item icono="bx bx-shield" ruta="{{ route('perfil.2fa.informacion') }}">
                Autenticación de Dos Factores
            </x-breadcrumb.item>
            <x-breadcrumb.current>Authenticator App</x-breadcrumb.current>
        </x-breadcrumb>
        @if ($enabled)
            <x-card class="space-y-5 mt-5 p-0 md:p-5 text-gray-800 dark:text-white">
                @if ($user->google2faEnabled())
                    @include('auth/authenticator-app/deshabilitar')
                @else
                    <div class="mb-5">
                        <x-card.title class="!text-md md:!text-2xl">Activación</x-card.title>
                        <p class="text-sm md:text-base text-gray-500 dark:text-neutral-400">
                            Realiza los siguentes pasos para activar este método de autenticación
                        </p>
                    </div>
                    @include('auth/authenticator-app/habilitar')
                @endif
            </x-card>
        @else
            <div class="max-w-md mx-auto mt-5">
                <x-alerta titulo="Servicio no disponible">
                    <x-alerta.mensaje>
                        Servicio se encuentra temporalmente no disponible, regrese más tarde.
                    </x-alerta.mensaje>
                </x-alerta>
            </div>
        @endif
    </x-section>
@endsection
