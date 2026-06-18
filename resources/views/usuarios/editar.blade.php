@extends('layouts/app')

@section('titulo', 'Actualizar Usuario ' . $usuario->usuario)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Actualizar Usuario" />
        <x-breadcrumb>
            <x-breadcrumb.item ruta="{{ route('usuarios.listado') }}" icono="bx bx-arrow-back">
                Usuarios
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('usuarios.detalle', $usuario) }}" icono="bx bx-user">
                {{ $usuario->usuario }}
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Actualizar
            </x-breadcrumb.current>
        </x-breadcrumb>
        <x-card class="p-5">
            <x-card.title>
                <i class="bx bx-edit-alt"></i>
                {{ $usuario->nombre }}
            </x-card.title>
            <form action="{{ route('usuarios.editar', $usuario) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
                    @include('usuarios/editar/formulario')
                    
                    <div class="xs:col-span-1 sm:col-span-2 md:col-span-3">
                        <x-input.label for="observacion" value="Observación" />
                        <x-input type="hidden" id="observacion" name="observacion" />
                        <x-editor id="hs-editor-tiptap">
                            {!! old('observacion') !!}
                        </x-editor>
                        <x-input.error campo="observacion" />
                    </div>
                </div>
                <div class="mt-5">
                    <x-input.button id="btn-editar-usuario">
                        Actualizar
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection

@push('page-scripts')
    @vite(['resources/js/editar-usuario.js'])
@endpush
