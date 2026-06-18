@props(['active'])

<x-button.link
    {{ $attributes->class([
        '!gap-x-3.5 !px-3 rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700',
        '' => $active,
    ]) }}>
    {{ $slot }}
</x-button.link>
