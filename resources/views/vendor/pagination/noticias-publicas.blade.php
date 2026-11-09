@php
if (! isset($scrollTo)) {
    $scrollTo = '#top-noticias-list';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (document.querySelector('{$scrollTo}') || \$el.closest('.container') || window).scrollIntoView({ behavior: 'smooth', block: 'start' })
    JS
    : '';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de páginas" class="d-flex flex-column align-items-center justify-content-center py-4 w-100">
        {{-- Paginador Estilo Cápsula Moderna Centrada (Inspirado en el Panel Admin) --}}
        <div class="d-inline-flex align-items-center gap-1 p-1 bg-white border rounded-pill shadow-sm" 
             style="border-color: rgba(0, 0, 0, 0.08) !important; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.07) !important;">
            
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Anterior" class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-muted small fw-semibold text-decoration-none opacity-50" style="cursor: not-allowed; user-select: none;">
                    <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
                    <span class="d-none d-sm-inline">Anterior</span>
                </span>
            @else
                <button type="button" 
                        wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                        wire:loading.attr="disabled" 
                        aria-label="Anterior"
                        class="btn btn-link d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-dark small fw-bold text-decoration-none border-0 shadow-none pagination-nav-btn transition-all">
                    <i class="fas fa-chevron-left text-danger" style="font-size: 0.75rem;"></i>
                    <span class="d-none d-sm-inline">Anterior</span>
                </button>
            @endif

            {{-- Números de Página --}}
            <div class="d-flex align-items-center gap-1 px-1">
                @foreach ($elements as $element)
                    {{-- Separador "..." --}}
                    @if (is_string($element))
                        <span class="d-flex align-items-center justify-content-center text-muted small fw-bold px-2" style="width: 36px; height: 36px; user-select: none;">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Links Numéricos --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      wire:key="paginator-{{ $paginator->getPageName() }}-current-{{ $page }}"
                                      class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold shadow-sm"
                                      style="width: 38px; height: 38px; font-size: 0.88rem; background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.35) !important; user-select: none; transform: scale(1.04);">
                                    {{ $page }}
                                </span>
                            @else
                                <button type="button"
                                        wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                        wire:loading.attr="disabled"
                                        aria-label="Ir a página {{ $page }}"
                                        class="btn btn-link d-flex align-items-center justify-content-center rounded-circle text-dark text-decoration-none border-0 shadow-none pagination-page-btn transition-all"
                                        style="width: 38px; height: 38px; font-size: 0.88rem; font-weight: 600; user-select: none;">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <button type="button" 
                        wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                        wire:loading.attr="disabled" 
                        aria-label="Siguiente"
                        class="btn btn-link d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-dark small fw-bold text-decoration-none border-0 shadow-none pagination-nav-btn transition-all">
                    <span class="d-none d-sm-inline">Siguiente</span>
                    <i class="fas fa-chevron-right text-danger" style="font-size: 0.75rem;"></i>
                </button>
            @else
                <span aria-disabled="true" aria-label="Siguiente" class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-muted small fw-semibold text-decoration-none opacity-50" style="cursor: not-allowed; user-select: none;">
                    <span class="d-none d-sm-inline">Siguiente</span>
                    <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
                </span>
            @endif
        </div>

        {{-- Texto de Resumen Centrado en Español --}}
        <p class="small text-muted mt-3 mb-0 text-center" style="font-size: 0.82rem; user-select: none;">
            Mostrando <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span>
            a <span class="fw-bold text-dark">{{ $paginator->lastItem() }}</span>
            de <span class="fw-bold text-danger">{{ $paginator->total() }}</span> resultados
        </p>
    </nav>

    <style>
        .pagination-nav-btn {
            color: #334155 !important;
            transition: all 0.2s ease;
        }
        .pagination-nav-btn:hover {
            background-color: #f8fafc !important;
            color: #dc3545 !important;
            transform: translateY(-1px);
        }
        .pagination-page-btn {
            color: #475569 !important;
            transition: all 0.2s ease;
        }
        .pagination-page-btn:hover {
            background-color: #f1f5f9 !important;
            color: #dc3545 !important;
            transform: translateY(-1px);
        }
    </style>
@endif
