@extends('layouts/app')

@section('titulo', 'Usuarios')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Usuarios" />
        @hasrole('Admin|Director')
            @include('usuarios/listado/indicadores')
        @endhasrole
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-1">
            <div class="col-span-1 sm:col-span-2 order-2 lg:order-1">
                @include('usuarios/listado/busqueda')
            </div>
            <div class="order-1 lg:order-2 place-content-center">
                <div class="flex justify-end">
                    <x-button.link href="{{ route('usuarios.registrar') }}"
                        class="rounded-lg text-red-500 hover:text-red-800 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                        <i class="bx bx-user-plus"></i>
                        Registrar
                    </x-button.link>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden rounded-lg space-y-3 pb-3">
                    @include('usuarios/listado/tabla')
                </div>
            </div>
        </div>
        @include('usuarios/modal-accion')
        {{ $usuarios->onEachSide(1)->links() }}
    </x-section>
@endsection

@hasrole('Admin|Director')
    @push('page-scripts')
        @vite('resources/js/countup-indicadores.js')
    @endpush
@endhasrole
