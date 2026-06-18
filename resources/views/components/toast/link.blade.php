@props(['ruta', 'descripcion'])

@if ($ruta)
    <a href="{{ $ruta }}"
        class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline dark:text-blue-500">
        {{ $descripcion }}
    </a>
@endif
