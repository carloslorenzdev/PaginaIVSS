@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-x-1">
        @if ($paginator->onFirstPage())
            <x-button disabled
                class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                <i class="bx bx-chevron-left"></i>
                Anterior
            </x-button>
        @else
            <x-button.link href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"
                class="rounded-lg text-blue-500 hover:text-blue-800 hover:bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                <i class="bx bx-chevron-left"></i>
                Anterior
            </x-button.link>
        @endif

        @if ($paginator->hasMorePages())
            <x-button.link href="{{ $paginator->nextPageUrl() }}" aria-label="Next"
                class="rounded-lg text-blue-500 hover:text-blue-800 hover:bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                Siguiente
                <i class="bx bx-chevron-right"></i>
            </x-button.link>
        @else
            <x-button disabled
                class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                Siguiente
                <i class="bx bx-chevron-right"></i>
            </x-button>
        @endif
    </nav>
@endif
