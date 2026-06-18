@extends('layouts/app')

@section('titulo', 'Desactivar 2FA Usuario ' . $usuario->usuario)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Desactivación 2FA a usuario" />
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
            <form action="{{ route('usuarios.desactivar-2fa', $usuario) }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
                    <div class="col-span-full">
                        <x-input.label for="metodo" value="Métodos 2FA" />
                        <div class="flex flex-col md:flex-row gap-2">
                            @foreach ($twoFactors as $key => $item)
                                @if ($item['estatus'])
                                    <label for="metodo-{{ $key }}"
                                        class="max-w-xs flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" name="metodo[{{ $key }}]"
                                            @checked(old('metodo.' . $key, $item['estatus']))
                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                            id="metodo-{{ $key }}" value="{{ $key }}">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                                            <i class="bx bx-{{ $item['icono'] }} !text-2xl"></i>
                                            {{ str()->of($key)->title() }}
                                        </span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        <x-input.error campo="metodo" />
                    </div>
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
                    <x-input.button id="btn-desactivar-2fa">
                        Registrar
                    </x-input.button>
                </div>
            </form>
        </x-card>
    </x-section>
@endsection

@push('page-scripts')
    @vite('resources/js/desactivar-2fa-usuario.js')
@endpush
