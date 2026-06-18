@props(['active' => false])

<x-button.link
    {{ $attributes->class([
        '!gap-x-3.5 px-2.5 text-gray-800 rounded-lg hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-900',
        'bg-gray-100 dark:bg-neutral-700' => $active,
    ]) }}>
    {{ $slot }}
</x-button.link>
