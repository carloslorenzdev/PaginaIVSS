@props(['id', 'maxWidth' => 'sm', 'titulo' => null, 'open' => false])

<div id="{{ $id }}"
    {{ $attributes->class([
        'hs-overlay hs-overlay-open:translate-x-0 translate-x-full fixed top-0 end-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white border-s dark:bg-neutral-800 dark:border-neutral-700',
        'hidden' => !$open,
        'open opened' => $open,
    ]) }}
    role="dialog" tabindex="-1" aria-overlay="{{ $open ? 'true' : 'false' }}" aria-labelledby="{{ $id }}-label">
    <x-modal.header id="{{ $id }}">
        <x-slot:titulo>
            {{ $titulo }}
        </x-slot:titulo>
    </x-modal.header>
    {{ $slot }}
</div>
