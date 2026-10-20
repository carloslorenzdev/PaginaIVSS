@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación" class="flex flex-col items-center justify-center gap-2 py-4 w-full">
        <div class="inline-flex items-center gap-1.5 p-1.5 rounded-2xl bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/80 shadow-sm backdrop-blur-sm">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-400 dark:text-neutral-600 cursor-not-allowed select-none opacity-50">
                    <i class="bx bx-chevron-left text-base"></i>
                    <span>Anterior</span>
                </span>
            @else
                <button type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-700 dark:text-neutral-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50/80 dark:hover:bg-neutral-700/60 transition-all select-none">
                    <i class="bx bx-chevron-left text-base"></i>
                    <span>Anterior</span>
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-700 dark:text-neutral-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50/80 dark:hover:bg-neutral-700/60 transition-all select-none">
                    <span>Siguiente</span>
                    <i class="bx bx-chevron-right text-base"></i>
                </button>
            @else
                <span aria-disabled="true" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-400 dark:text-neutral-600 cursor-not-allowed select-none opacity-50">
                    <span>Siguiente</span>
                    <i class="bx bx-chevron-right text-base"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
