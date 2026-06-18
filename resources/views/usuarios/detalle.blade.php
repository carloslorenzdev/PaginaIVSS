@extends('layouts/app')

@section('titulo', 'Perfil de ' . $user->usuario)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Perfil de {{ $user->usuario }}" />
        <x-breadcrumb class="mb-5">
            <x-breadcrumb.item ruta="{{ route('usuarios.listado') }}" icono="bx bx-arrow-back">
                Usuarios
            </x-breadcrumb.item>
            <x-breadcrumb.current icono="bx bx-user">
                {{ $user->usuario }}
            </x-breadcrumb.current>
        </x-breadcrumb>
        @include('usuarios/detalle/botones')
        @include('usuarios/modal-accion')
        <x-card>
            @include('usuarios/detalle/card-usuario')
        </x-card>
        <x-card>
            @include('usuarios/detalle/info')
        </x-card>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 md:gap-7">
            <x-card>
                @include('usuarios/detalle/ultimos-accesos')
            </x-card>
            <x-card class="p-5">
                @include('usuarios/detalle/lista-2fa')
            </x-card>
            <x-card class="p-5">
                @include('usuarios/detalle/observaciones')
            </x-card>
        </div>
    </x-section>
@endsection
