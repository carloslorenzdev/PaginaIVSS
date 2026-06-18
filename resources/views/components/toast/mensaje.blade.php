@props(['mensaje'])

@if ($mensaje)
    <h3 id="hs-toast-avatar-label" class="font-semibold text-sm mb-0 text-gray-800 dark:text-white">
        {{ $mensaje }}
    </h3>
@endif
