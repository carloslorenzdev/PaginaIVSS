@props(['mensaje'])

<p class="text-sm text-gray-700 dark:text-neutral-400">
    {{ $mensaje ?? $slot }}
</p>
