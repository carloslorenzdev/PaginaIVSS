@props(['tbody' => false, 'odd' => false])

<tr
    {{ $attributes->class([
        'hover:bg-gray-100/60 dark:hover:bg-neutral-700/60' => $tbody,
        'odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-800 dark:even:bg-neutral-700' => $odd,
    ]) }}>
    {{ $slot }}
</tr>
