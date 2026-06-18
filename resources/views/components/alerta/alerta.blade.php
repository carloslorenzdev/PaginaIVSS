@props([
    'color' => 'blue',
    'icono' => 'bx bx-message-alt-check',
    'titulo' => null,
    'mensaje' => null,
    'colorIcono' => null,
])

@php

    $bgColor = match ($color) {
        'red' => 'bg-red-50 border-t-2 border-red-500 dark:bg-red-800/30',
        'teal' => 'bg-teal-50 border-t-2 border-teal-500 dark:bg-teal-800/30',
        'yellow' => 'bg-yellow-50 border-t-2 border-yellow-500 dark:bg-yellow-800/30',
        default => 'bg-blue-50 border-t-2 border-blue-500 dark:bg-blue-800/30',
    };

    $colorIcono = $colorIcono ?: $color;
    $colorIcono = match ($color) {
        'red' => 'border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400',
        'teal' => 'border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400',
        'yellow' => 'border-yellow-100 bg-yellow-200 text-yellow-800 dark:border-yellow-900 dark:bg-yellow-800
dark:text-yellow-400',
        default
            => 'border-blue-100 bg-blue-200 text-blue-800 dark:border-blue-900 dark:bg-blue-800 dark:text-blue-400',
    };

@endphp

<div {{ $attributes->class(['rounded-lg shadow p-4', $bgColor]) }}>
    <div class="flex">
        <div class="shrink-0">
            <span class="justify-center items-center size-8 rounded-full border-4 {{ $colorIcono }}">
                <i class="{{ $icono }} shink-0"></i>
            </span>
        </div>
        <div class="ms-3">
            @if ($titulo)
                <x-alerta.titulo titulo="{{ $titulo }}" />
            @endif
            @if ($mensaje)
                <x-alerta.mensaje mensaje="{{ $mensaje }}" />
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
