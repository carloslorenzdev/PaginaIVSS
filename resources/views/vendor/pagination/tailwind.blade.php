@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de páginas" class="flex flex-col items-center justify-center gap-3 py-6 w-full">
        {{-- Paginador Estilo Cápsula Moderna Centrada --}}
        <div class="inline-flex items-center gap-1.5 p-1.5 rounded-2xl bg-white dark:bg-neutral-800 border border-gray-100 dark:border-neutral-700/80 shadow-sm backdrop-blur-sm">
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Anterior" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-400 dark:text-neutral-600 cursor-not-allowed select-none opacity-50">
                    <i class="bx bx-chevron-left text-base"></i>
                    <span class="hidden sm:inline">Anterior</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-700 dark:text-neutral-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50/80 dark:hover:bg-neutral-700/60 transition-all select-none">
                    <i class="bx bx-chevron-left text-base"></i>
                    <span class="hidden sm:inline">Anterior</span>
                </a>
            @endif

            {{-- Números de Página --}}
            <div class="flex items-center gap-1 px-1">
                @foreach ($elements as $element)
                    {{-- Separador "..." --}}
                    @if (is_string($element))
                        <span class="size-9 flex items-center justify-center text-xs font-bold text-gray-400 dark:text-neutral-500 select-none">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Links Numéricos --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="size-9 flex items-center justify-center rounded-xl text-xs font-extrabold bg-gradient-to-r from-teal-600 to-teal-500 text-white shadow-md shadow-teal-500/30 scale-105 select-none transition-all">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   aria-label="{{ __('Ir a página :page', ['page' => $page]) }}"
                                   class="size-9 flex items-center justify-center rounded-xl text-xs font-semibold text-gray-700 dark:text-neutral-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50/80 dark:hover:bg-neutral-700/60 transition-all select-none">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-700 dark:text-neutral-300 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50/80 dark:hover:bg-neutral-700/60 transition-all select-none">
                    <span class="hidden sm:inline">Siguiente</span>
                    <i class="bx bx-chevron-right text-base"></i>
                </a>
            @else
                <span aria-disabled="true" aria-label="Siguiente" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-gray-400 dark:text-neutral-600 cursor-not-allowed select-none opacity-50">
                    <span class="hidden sm:inline">Siguiente</span>
                    <i class="bx bx-chevron-right text-base"></i>
                </span>
            @endif
        </div>

        {{-- Texto de Resumen Centrado --}}
        <p class="text-xs font-medium text-gray-500 dark:text-neutral-400 select-none">
            Mostrando <span class="font-bold text-gray-800 dark:text-neutral-200">{{ $paginator->firstItem() }}</span>
            a <span class="font-bold text-gray-800 dark:text-neutral-200">{{ $paginator->lastItem() }}</span>
            de <span class="font-bold text-teal-600 dark:text-teal-400">{{ $paginator->total() }}</span> registros
        </p>
    </nav>
@endif
