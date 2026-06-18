@props(['id', 'maxWidth' => 'sm', 'titulo' => null])

@php

    $maxWidth = [
        'sm' => 'sm:max-w-lg sm:w-full m-3 sm:mx-auto',
        'md' => 'md:max-w-2xl md:w-full m-3 md:mx-auto',
        'lg' => 'lg:max-w-4xl lg:w-full m-3 lg:mx-auto',
        'xl' => 'xl:max-w-6xl xl:w-full m-3 xl:mx-auto',
    ][$maxWidth];

    $classes = 'hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out
transition-all min-h-[calc(100%-3.5rem)] flex items-center ';
    $classes .= $maxWidth;

@endphp

<div id="{{ $id }}"
    class="hs-overlay hs-overlay-open:backdrop-blur-sm hs-overlay-open:backdrop-saturate-100 hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
    role="dialog" tabindex="-1" aria-labelledby="{{ $id }}-label">
    <div {{ $attributes->merge(['class' => $classes]) }}>
        <div
            class="w-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <x-modal.header id="{{ $id }}" titulo="{{ $titulo }}" />
            {{ $slot }}
        </div>
    </div>
</div>
