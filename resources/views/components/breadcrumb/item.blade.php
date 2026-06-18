@props(['ruta', 'icono' => null])

@props(['icono' => null])

<li {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <a class="flex items-center text-sm text-gray-500 hover:text-red-600 focus:outline-none focus:text-red-600 dark:text-neutral-500 dark:hover:text-red-500 dark:focus:text-red-500"
        href="{{ $ruta }}">
        @if ($icono)
            <i class="{{ $icono }} bx-xs me-1"></i>
        @endif
        <p class="max-w-[200px] truncate overflow-hidden">
            {{ $slot }}
        </p>
    </a>
    <i class="bx bx-chevron-right mx-2 text-gray-400 dark:text-neutral-600"></i>
</li>
