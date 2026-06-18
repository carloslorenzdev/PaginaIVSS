@props(['boton', 'header' => null, 'align' => 'bottom-right'])

<div {{ $attributes->merge(['class' => 'hs-dropdown relative inline-flex [--placement:' . $align . ']']) }}>
    <x-dropdown.button class="{{ $boton->attributes->get('class') }}" id="{{ $boton->attributes->get('id') }}">
        {{ $boton }}
    </x-dropdown.button>

    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full z-10"
        role="menu" aria-orientation="vertical" aria-labelledby="{{ $boton->attributes->get('id') }}">
        @if ($header)
            <x-dropdown.header class="{{ $header->attributes->get('class') }}">
                {{ $header }}
            </x-dropdown.header>
        @endif
        {{ $slot }}
    </div>
</div>
