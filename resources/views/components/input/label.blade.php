@props(['value' => null, 'opcional' => false])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium mb-2 dark:text-white']) }}>
    {{ $value ?? $slot }}
    @if ($opcional)
        <span class="text-neutral-400">
            (opcional)
        </span>
    @endif
</label>
