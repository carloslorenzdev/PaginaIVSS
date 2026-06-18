@props(['toggleTarget' => '"#' . $attributes->get('id') . '"', 'classContainer' => ''])

@php
    $toggleTarget = '{"target": ' . $toggleTarget . '}';
@endphp

<div class="relative {{ $classContainer }}">
    <x-input type="password" {{ $attributes }} />
    <button type="button" data-hs-toggle-password="{{ $toggleTarget }}"
        class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
        <x-iconos.input-password />
    </button>
</div>
