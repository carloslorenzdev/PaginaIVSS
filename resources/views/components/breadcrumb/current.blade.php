@props(['icono' => null])

<li
    {{ $attributes->merge([
        'class' => 'flex items-center text-sm font-semibold text-gray-800 truncate dark:text-neutral-200',
        'aria-current' => 'page',
    ]) }}>
    @if ($icono)
        <i class="{{ $icono }} bx-xs me-1"></i>
    @endif
    {{ $slot }}
</li>
