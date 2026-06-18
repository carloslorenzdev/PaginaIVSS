@props(['descripcion' => null, 'size' => 'size-7'])

@php
    $size = match ($size) {
        'size-5' => 'size-5 text-[0.5rem]',
        'size-6' => 'size-6 text-[0.6rem]',
        'size-7' => 'size-7 text-[0.7rem]',
        'size-10' => 'size-10 text-[0.8rem]',
        default => 'size-7 text-[0.7rem]',
    };
@endphp

@if ($attributes->has('src'))
    <img {{ $attributes->class(['inline-block rounded-full ring-2 ring-white dark:ring-neutral-900', $size]) }}>
@else
    <div {{ $attributes->class(['inline-block rounded-full ring-2 ring-white dark:ring-neutral-900', $size]) }}>
        <div
            class="inline-flex justify-center items-center rounded-full bg-gray-300 dark:bg-gray-800 dark:text-neutral-200 {{ $size }}">
            {{ $descripcion ?? $slot }}
        </div>
    </div>
@endif
