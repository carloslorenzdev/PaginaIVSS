@props(['id' => 'horizontal-alignment', 'ruta' => null, 'active' => false])

@php
    $classBase = 'py-4 px-1 border-b-2 whitespace-nowrap';
    $classActive = $active
        ? 'font-semibold border-red-600 text-red-600'
        : 'border-transparent text-gray-500 hover:text-red-600 focus:text-red-600 dark:text-neutral-400 dark:hover:text-red-500';
@endphp

@if ($ruta)
    <x-button.link href="{{ $ruta }}"
        {{ $attributes->class([$classBase, $classActive])->merge([
            'aria-controls' => $id,
            'data-hs-tab' => '#' . $id,
            'aria-selected' => $active ? 'true' : 'false',
            'id' => $id,
        ]) }}
        role="tab">
        {{ $slot }}
    </x-button.link>
@else
    <button type="button"
        class="hs-tab-active:font-semibold hs-tab-active:border-red-600 hs-tab-active:text-red-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-red-600 focus:outline-none focus:text-red-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-red-500"
        {{ $attributes->merge([
            'id' => $id,
            'aria-controls' => $id,
            'data-hs-tab' => '#' . $id,
            'aria-selected' => $active ? 'true' : 'false',
        ]) }}
        role="tab">
        {{ $slot }}
    </button>
@endif
