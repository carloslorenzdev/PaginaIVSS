@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-x-1">
        <div class="flex justify-between items-center flex-1 sm:hidden">
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
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:flex-col sm:gap-y-4 md:flex-row md:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                    {!! __('Mostando del') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('al') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('de') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('resultados') !!}
                </p>
            </div>

            <div class="relative z-0 inline-flex rtl:flex-row-reverse gap-x-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <x-button disabled
                        class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <i class="bx bx-chevron-left"></i>
                    </x-button>
                @else
                    <x-button.link href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"
                        class="rounded-lg text-blue-500 hover:text-blue-800 hover:bg-blue-100 dark:hover:bg-blue-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                        <i class="bx bx-chevron-left"></i>
                    </x-button.link>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <x-button disabled
                            class="min-h-[38px] min-w-[38px] justify-center rounded-lg text-gray-800 dark:text-white">
                            {{ $element }}
                        </x-button>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <x-button aria-current="page"
                                    class="min-h-[38px] min-w-[38px] justify-center rounded-lg font-semibold text-white bg-blue-800 dark:bg-blue-900">
                                    {{ $page }}
                                </x-button>
                            @else
                                <x-button.link href="{{ $url }}"
                                    aria-label="{{ __('Ir a página :page', ['page' => $page]) }}"
                                    class="min-h-[38px] min-w-[38px] justify-center rounded-lg text-blue-500 hover:text-blue-800 hover:bg-blue-100 dark:hover:bg-blue-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                                    {{ $page }}
                                </x-button.link>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <x-button.link href="{{ $paginator->nextPageUrl() }}" aria-label="Next"
                        class="rounded-lg text-blue-500 hover:text-blue-800 hover:bg-blue-100 dark:hover:bg-blue-700 dark:text-neutral-100 dark:hover:text-white dark:focus:text-white">
                        <i class="bx bx-chevron-right"></i>
                    </x-button.link>
                @else
                    <x-button disabled
                        class="rounded-lg text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <i class="bx bx-chevron-right"></i>
                    </x-button>
                @endif
            </div>
        </div>
    </nav>
@endif
