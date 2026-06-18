<x-button type="button"
    {{ $attributes->merge([
        'class' =>
            'hs-accordion-toggle text-start text-gray-800 rounded-lg hover:bg-gray-100 focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 w-full',
    ]) }}>
    {{ $slot }}
    <i class='bx bx-chevron-down hs-accordion-active:rotate-180 transition-all ms-auto'></i>
</x-button>
