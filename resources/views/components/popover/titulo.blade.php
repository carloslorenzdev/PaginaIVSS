@props(['titulo', 'subtitulo' => null])

<div {{ $attributes->class(['grow']) }}>
    <h4 class="font-semibold text-gray-800 dark:text-white">
        {{ $titulo }}
    </h4>
    @if ($subtitulo)
        <p class="text-sm text-gray-500 dark:text-neutral-500">
            {{ $subtitulo }}
        </p>
    @endif
</div>
