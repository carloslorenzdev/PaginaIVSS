@extends('layouts/app')

@section('titulo', 'Observaciones del Usuario ' . $user->usuario)

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Observaciones" />
        <x-breadcrumb class="mb-5">
            <x-breadcrumb.item ruta="{{ route('usuarios.listado') }}" icono="bx bx-arrow-back">
                Usuarios
            </x-breadcrumb.item>
            <x-breadcrumb.item ruta="{{ route('usuarios.detalle', $user) }}" icono="bx bx-user">
                {{ $user->usuario }}
            </x-breadcrumb.item>
            <x-breadcrumb.current>
                Observaciones
            </x-breadcrumb.current>
        </x-breadcrumb>
        <div class="space-y-1 w-full tiptap !break-words">
            <x-card class="p-5">
                @forelse ($observaciones as $item)
                    <div class="flex gap-x-3">
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-red-200 dark:after:bg-red-700">
                            <x-avatar.item class="relative z-10" descripcion="{{ $item->creador->iniciales }}" />
                        </div>
                        <div class="grow pt-0.5 pb-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-white m-0">
                                    {{ $item->creador->nombre }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-neutral-400">
                                    {{ $item->fechaHumanos('created_at') }}
                                </p>
                            </div>
                            <div
                                class="mt-2 space-y-2 text-sm max-h-40 overflow-y-auto text-gray-800 dark:text-neutral-200">
                                {!! $item->observacion !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center text-gray-500 dark:text-neutral-400">
                        <i class="bx bx-message-minus" style="font-size: 2rem;"></i>
                        <p>Aún sin Observaciones</p>
                    </div>
                @endforelse
            </x-card>
        </div>
        {{ $observaciones->onEachSide(1)->links() }}
    </x-section>
@endsection
