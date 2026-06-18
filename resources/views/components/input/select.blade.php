@props(['error' => false])

@php
    $colorLight = 'border-gray-200 focus:border-blue-500 focus:ring-blue-500';
    $colorDark = 'dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600';

    $classes = 'py-3 px-4 pe-9 block w-full rounded-lg text-sm disabled:opacity-50 disabled:pointer-events-none
dark:placeholder-neutral-500';

    if ($errors->get($attributes->get('name'))) {
        $colorLight = 'border-red-200 focus:border-red-500 focus:ring-red-500';
        $colorDark = 'dark:bg-neutral-900 dark:border-red-700 dark:text-red-400 dark:focus:ring-red-600';
    }

    $classes = "$classes $colorLight $colorDark";
@endphp

<select {{ $attributes->class([$classes]) }} aria-describedby="{{ $attributes->get('name') }}-helper"
    @disabled($attributes->get('disabled'))>
    {{ $slot }}
</select>
@if ($error)
    <x-input.error campo="{{ $attributes->get('name') }}" />
@endif
