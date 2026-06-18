@props(['heading', 'active'])

<div {{ $attributes->class(['hs-accordion', 'active' => $active]) }}>
    <x-nav.accordion-button aria-expanded="{{ $active ? 'true' : 'false' }}"
        aria-controls="{{ $attributes->get('id') }}-child" class="{{ $heading->attributes->get('class') }}">
        {{ $heading }}
    </x-nav.accordion-button>
    <div id="{{ $attributes->get('id') }}-child"
        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ $active ? 'block' : 'hidden' }}"
        role="region" aria-labelledby="{{ $attributes->get('id') }}">
        {{ $slot }}
    </div>
</div>
