@props(['error' => false])

@php
    $tipo = $attributes->get('type') === 'password' ? 'py-3 ps-4 pe-10' : 'py-3 px-4';

    $colorLight = 'border-gray-200 focus:border-blue-500 focus:ring-blue-500';
    $colorDark = 'dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600';

    $classes = 'block w-full shadow-sm rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none
dark:bg-neutral-900 dark:placeholder-neutral-500';

    if ($errors->get($attributes->get('name'))) {
        $colorLight = 'border-red-200 focus:border-red-500 focus:ring-red-500';
        $colorDark = 'dark:border-red-700 dark:text-red-400 dark:focus:ring-red-600';
    }

    $classes = "$classes $colorLight $colorDark";

@endphp

<input {{ $attributes->class([$classes, $tipo]) }} aria-describedby="{{ $attributes->get('name') }}-helper">
@if ($error)
    <x-input.error campo="{{ $attributes->get('name') }}" />
@endif
