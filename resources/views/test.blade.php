@extends('layouts/blank')

@section('titulo', 'Test BD')

@section('content')
    <div class="absolute right-5 pt-2.5">
        @include('layouts/sections/navbar/mode-theme')
    </div>
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Test BD" />
        <x-button.link href="/"
            class="text-gray-500 hover:text-red-600 focus:text-red-600 dark:text-neutral-500 dark:hover:text-red-500 dark:focus:text-red-500">
            <i class="bx bx-arrow-back"></i>
            Volver
        </x-button.link>
        <div class="flex justify-center">
            <div class="text-gray-700 dark:text-neutral-500">
                <i class="bx bx-server" style="font-size: 7rem;"></i>
                <p class="text-lg text-center">Server</p>
            </div>
        </div>
        <div class="flex justify-center gap-x-10">
            <div class="max-w-md">
                <div class="w-full space-y-5">
                    <x-alerta titulo="Principal" mensaje="{{ $principal['mensaje'] }}" color="{{ $principal['color'] }}">
                        <small class="text-xs text-gray-700 dark:text-neutral-400">
                            {{ $principal['pdo'] }}
                        </small>
                        <pre class="hidden">
                            {{ json_encode($principal['pdo']) }}
                        </pre>
                    </x-alerta>
                </div>
            </div>
            @if (isset($secundaria) && array_key_exists('mensaje', $secundaria))
                <div class="max-w-md">
                    <div class="w-full space-y-5">
                        <x-alerta titulo="Secundaria" mensaje="{{ $secundaria['mensaje'] }}"
                            color="{{ $secundaria['color'] }}">
                            <small class="text-xs text-gray-700 dark:text-neutral-400">
                                {{ $secundaria['pdo'] }}
                            </small>
                            <pre class="hidden">
                                {{ json_encode($secundaria['pdo']) }}
                            </pre>
                        </x-alerta>
                    </div>
                </div>
            @endif
        </div>
    </x-section>
@endsection
