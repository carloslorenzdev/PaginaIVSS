@extends('layouts/app')

@section('titulo', 'Autenticación de dos factores')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Autenticación de Dos Factores (2FA)" />
        <x-breadcrumb>
            <x-breadcrumb.item icono="bx bx-arrow-back" ruta="{{ route('perfil.detalle') }}">
                Mi Perfil
            </x-breadcrumb.item>
            <x-breadcrumb.current>2FA</x-breadcrumb.current>
        </x-breadcrumb>
        <x-card class="space-y-5 mt-5 p-5 text-gray-800 dark:text-white">
            @include('perfil.2fa.definicion')
            @include('perfil.2fa.funcion')
            @include('perfil.2fa.beneficios')
        </x-card>
        @include('perfil.2fa.metodos')
    </x-section>
@endsection
