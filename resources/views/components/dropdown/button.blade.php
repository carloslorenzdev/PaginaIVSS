<x-button aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown"
    {{ $attributes->merge(['class' => 'hs-dropdown-toggle font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700']) }}>
    {{ $slot }}
</x-button>
